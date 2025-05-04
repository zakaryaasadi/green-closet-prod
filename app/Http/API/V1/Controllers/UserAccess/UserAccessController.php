<?php

namespace App\Http\API\V1\Controllers\UserAccess;

use App\Http\API\V1\Controllers\Controller;
use App\Http\API\V1\Repositories\UserAccess\UserAccessRepository;
use App\Http\API\V1\Requests\UserAccess\StoreUserAccessRequest;
use App\Http\API\V1\Requests\UserAccess\UpdateUserAccessRequest;
use App\Http\Resources\UserAccess\UserAccessResource;
use App\Models\UserAccess;
use Illuminate\Http\JsonResponse;

/**
 * @group User Access
 * APIs for User Access settings
 */
class UserAccessController extends Controller
{
    protected UserAccessRepository $userAccessRepository;

    public function __construct(UserAccessRepository $userAccessRepository)
    {
        $this->middleware(['auth:sanctum']);
        $this->userAccessRepository = $userAccessRepository;
        $this->authorizeResource(UserAccess::class);
    }

    /**
     * Show all users access
     *
     * This endpoint lets you show all users access
     *
     * @responseFile storage/responses/userAccess/index.json
     *
     * @queryParam page int Field to select page. Defaults to '1'.
     * @queryParam per_page int Field to select items per page. Defaults to '15'.
     * @queryParam filter[id] string Field to filter items by id.
     * @queryParam filter[user_id] string Field to filter items by user id.
     * @queryParam filter[country_id] string Field to filter items by country id.
     * @queryParam filter[user_name] string Field to filter items by user name.
     * @queryParam filter[access_level] string Field to filter items by access level.
     * @queryParam sort string Field to sort items by id,user id, country id, access level
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $paginatedData = $this->userAccessRepository->index();

        return $this->showAll($paginatedData->getData(), UserAccessResource::class, $paginatedData->getPagination());
    }

    /**
     * Show specific user access
     *
     * This endpoint lets you show specific user access
     *
     * @responseFile storage/responses/userAccess/show.json
     *
     * @param UserAccess $userAccess
     * @return JsonResponse
     */
    public function show(UserAccess $userAccess): JsonResponse
    {
        return $this->showOne($this->userAccessRepository->show($userAccess), UserAccessResource::class);
    }

    /**
     * Add user access
     *
     * This endpoint lets you add user access
     *
     * @responseFile storage/responses/userAccess/store.json
     *
     * @param StoreUserAccessRequest $request
     * @return JsonResponse
     */
    public function store(StoreUserAccessRequest $request): JsonResponse
    {
        $data = $request->validated();
        $userAccess = $this->userAccessRepository->storeAccess($data);

        return $this->showOne($userAccess, UserAccessResource::class, __('The access added successfully'));
    }

    /**
     * Update specific user access
     *
     * This endpoint lets you update specific user access
     *
     * @responseFile storage/responses/userAccess/update.json
     *
     * @param UpdateUserAccessRequest $request
     * @param UserAccess $userAccess
     * @return JsonResponse
     */
    public function update(UpdateUserAccessRequest $request, UserAccess $userAccess): JsonResponse
    {
        $data = $request->validated();
        $accessUpdated = $this->userAccessRepository->updateAccess($data, $userAccess);

        return $this->showOne($accessUpdated, UserAccessResource::class, __("Access's information updated successfully"));
    }

    /**
     * Delete specific user access
     *
     * This endpoint lets you delete specific user access
     *
     * @responseFile storage/responses/userAccess/delete.json
     *
     * @param UserAccess $userAccess
     * @return JsonResponse
     */
    public function destroy(UserAccess $userAccess): JsonResponse
    {
        $this->userAccessRepository->delete($userAccess);

        return $this->responseMessage(__('User Access deleted successfully'));

    }
}
