<?php

namespace App\Http\API\V1\Controllers\User;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\User\UserRepository;
use App\Http\API\V1\Requests\User\Role\EditUserRoleRequest;
use App\Http\API\V1\Requests\User\StoreUserRequest;
use App\Http\API\V1\Requests\User\UpdateAgentSettingsRequest;
use App\Http\API\V1\Requests\User\UpdateUserPermissionRequest;
use App\Http\API\V1\Requests\User\UpdateUserRequest;
use App\Http\Resources\Role\RoleResource;
use App\Http\Resources\User\FullUserResource;
use App\Http\Resources\User\MeResource;
use App\Http\Resources\User\SimpleAgentResource;
use App\Models\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * @group Users
 * APIs for user Management
 */
class UserController extends Controller
{
    protected UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->middleware(['auth:sanctum'])->except([
            'updateUserCountry',
        ]);
        $this->userRepository = $userRepository;
        $this->authorizeResource(User::class);
    }

    /**
     * Show all users
     *
     * This endpoint lets you show all users
     *
     * @responseFile storage/responses/admin/users/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     *
     * @queryParamus filter[name] string Field to filter items by name.
     *
     * @queryParam filter[email] string Field to filter items by email.
     * @queryParam filter[phone] string Field to filter items by phone.
     * @queryParam filter[country_id] string Field to filter items by country_id.
     * @queryParam filter[type] string Field to filter items by type.
     * @queryParam filter[search] string Field to filter items by phone,name,email.
     * @queryParam sort string Field to sort items by id,name,email.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->userRepository->index();

        return $this->showAll($paginatedData->getData(), FullUserResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific user
     *
     * This endpoint lets you show specific user
     *
     * @responseFile storage/responses/admin/users/show.json
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->response('success', $this->userRepository->showUserDetails($user));
    }

    /**
     * Add user
     *
     * This endpoint lets you add user
     *
     * @responseFile storage/responses/admin/users/store.json
     *
     * @param StoreUserRequest $request
     * @return JsonResponse
     *
     * @throws Exception
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        return $this->userRepository->storeUser($request->validated());

    }

    /**
     * Update specific user
     *
     * This endpoint lets you update specific user
     *
     * @responseFile storage/responses/admin/users/update.json
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $updatedUser = $this->userRepository->update($user, $request->validated());

        return $this->showOne($updatedUser, FullUserResource::class, __("User's information updated successfully"));
    }

    /**
     * Delete specific user
     *
     * This endpoint lets you user specific user
     *
     * @responseFile storage/responses/admin/users/delete.json
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $currentUser = Auth::user();
        if ($user->is($currentUser)) {
            return $this->responseMessage(__('This operation is not permitted,You can not delete yourself'), Response::HTTP_CONFLICT);
        }
        $this->userRepository->delete($user);

        return $this->responseMessage(__('The user deleted successfully'));

    }

    /**
     * Show all roles to specific user
     *
     * This endpoint lets you show all roles to specific user
     *
     * @responseFile storage/responses/admin/users/roles/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter string Field to filter items by id,name,description.
     * @queryParam sort string Field to sort items by id,name,description.
     *
     * @param User $user
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function indexRoles(User $user): JsonResponse
    {
        $this->authorize('viewAnyUserRoles', $user);
        $paginatedData = $this->userRepository->indexRoles($user);

        return $this->showAll($paginatedData->getData(), RoleResource::class, $paginatedData->getPagination());
    }

    /**
     * Edit user's roles
     *
     * This endpoint lets you edit user's roles (add,update,delete)
     *
     * @responseFile storage/responses/admin/users/roles/store.json
     *
     * @param EditUserRoleRequest $request
     * @param User $user
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function storeRoles(EditUserRoleRequest $request, User $user): JsonResponse
    {
        $this->authorize('createUserRoles', $user);

        return $this->userRepository->editRoles($request->validated()['role_ids'], $user);
    }

    /**
     * Show user's profile
     *
     * This endpoint lets you show user's authenticated profile
     *
     * @responseFile storage/responses/admin/users/profile.json
     *
     * @return JsonResponse
     */
    public function profile(): JsonResponse
    {
        return $this->showOne($this->userRepository->profile(), FullUserResource::class);
    }

    /**
     * update user's permissions by country
     *
     * This endpoint lets you update user's permissions by country
     *
     * @responseFile storage/responses/admin/users/permissions.json
     *
     * @param UpdateUserPermissionRequest $request
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function updateUserPermission(UpdateUserPermissionRequest $request): JsonResponse
    {
        $this->authorize('updateUserPermission', Auth::user());
        $user = $this->userRepository->updateUserPermission(Auth::user(), $request->validated());

        return $this->showOne($user, MeResource::class, __('User permissions updated successfully'));
    }

    /**
     * update agent's settings
     *
     * This endpoint lets you update agent's settings
     *
     * @responseFile storage/responses/admin/agents/settings.json
     *
     * @param UpdateAgentSettingsRequest $request
     * @return JsonResponse
     *
     * @throws AuthorizationException
     */
    public function updateAgentSettings(UpdateAgentSettingsRequest $request): JsonResponse
    {
        $this->authorize('updateAgentSettings', Auth::user());
        $data = collect($request->validated());
        $agentWithSettings = $this->userRepository->updateAgentSettings($data);

        return $this->showOne($agentWithSettings, SimpleAgentResource::class, __('Agent settings updated successfully'));

    }

    /**
     * update user country
     *
     * This endpoint lets you update user country
     *
     * @responseFile storage/responses/client/update-country.json
     *
     * @param UpdateUserRequest $request
     * @return JsonResponse
     */
    public function updateUserCountry(UpdateUserRequest $request): JsonResponse
    {
        return $this->userRepository->updateUserCountry($request->validated());

    }
}
