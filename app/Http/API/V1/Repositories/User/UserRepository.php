<?php

namespace App\Http\API\V1\Repositories\User;

use App\Enums\PermissionType;
use App\Enums\UserType;
use App\Filters\AdminFilter;
use App\Filters\CountryCustomFilter;
use App\Filters\PhoneCustomFilter;
use App\Helpers\AppHelper;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Http\Resources\User\AssociationSimpleResource;
use App\Http\Resources\User\ClientResource;
use App\Http\Resources\User\FullUserResource;
use App\Http\Resources\User\MeResource;
use App\Http\Resources\User\SimpleAgentResource;
use App\Models\AgentSettings;
use App\Models\Association;
use App\Models\Permission;
use App\Models\Setting;
use App\Models\User;
use App\Models\UserAccess;
use App\Traits\ApiResponse;
use App\Traits\FcmNotification;
use App\Traits\FileManagement;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use ipinfo\ipinfo\IPinfoException;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class UserRepository extends BaseRepository
{
    use FcmNotification, FileManagement, ApiResponse;

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {

        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::partial('name'),
            AllowedFilter::partial('email'),
            AllowedFilter::custom('phone', new PhoneCustomFilter()),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('type'),
            AllowedFilter::custom('search', new CountryCustomFilter(['name', 'email', 'phone'])),
            AllowedFilter::custom('admin', new AdminFilter(['name', 'email', 'phone'])),
        ];

        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('name'),
            AllowedSort::field('email'),
            AllowedSort::field('created_at'),
        ];

        return $this->filter(User::class, $filters, $sorts);
    }

    public function showUserDetails(User $user): SimpleAgentResource|AssociationSimpleResource|ClientResource|FullUserResource|MeResource
    {
        if ($user->type == UserType::ADMIN)
            return new MeResource($user);

        if ($user->type == UserType::CLIENT)
            return new ClientResource($user);

        if ($user->type == UserType::ASSOCIATION)
            return new AssociationSimpleResource($user);

        if ($user->type == UserType::AGENT)
            return new SimpleAgentResource($user);

        return new FullUserResource($user);
    }

    /**
     * @throws IPinfoException
     */
    public function storeUser($data): JsonResponse
    {
        if (array_key_exists('phone', $data) && !array_key_exists('email', $data)) {
            $phone = $data['phone'];
            $userDeleted = User::onlyTrashed()->where('phone', '=', $phone)->first();
            if ($userDeleted != null) {
                $user = $userDeleted;
                $user->restore();
            } else {
                $user = User::wherePhone($phone)->first();
                if ($user == null)
                    $user = parent::store($data);
                else
                    return $this->responseMessage(__('This user is exist'), 422);
            }
        } else {
            $phone = $data['phone'];
            $email = $data['email'];
            $userPhoneDeleted = User::onlyTrashed()->where('phone', '=', $phone)->first();
            $userEmailDeleted = User::onlyTrashed()->where('email', '=', $email)->first();
            if ($userPhoneDeleted != null && $userEmailDeleted != null) {
                if ($userPhoneDeleted == $userEmailDeleted) {
                    $user = $userPhoneDeleted;
                    $user->restore();
                } else
                    return $this->responseMessage(__("You can't make this user"), 422);
            } elseif ($userPhoneDeleted != null && $userEmailDeleted == null && $userPhoneDeleted->type == UserType::CLIENT) {
                $user = $userPhoneDeleted;
                $user->restore();
            } elseif (($userPhoneDeleted == null && $userEmailDeleted == null)) {
                $userPhone = User::wherePhone($phone)->first();
                $userEmail = User::whereEmail($email)->first();
                if ($userPhone == null && $userEmail == null)
                    $user = parent::store($data);
                else
                    return $this->responseMessage(__("You can't make this user"), 422);
            } else
                return $this->responseMessage(__('This user is exist'), 422);
        }

        if (array_key_exists('type', $data)) {
            $user->setType($data['type']);
            if ($data['type'] == UserType::AGENT) {
                $country = AppHelper::getCoutnryForMobile();
                $settings = Setting::whereCountryId($country->id)?->first() ?? Setting::where(['country_id' => null])->first();
                $agentSettings = new AgentSettings();
                $agentSettings->agent_id = $user->id;
                $agentSettings->tasks_per_day = $settings->tasks_per_day;
                $agentSettings->budget = $settings->budget;
                $agentSettings->start_work = $settings->start_work;
                $agentSettings->finish_work = $settings->finish_work;
                $agentSettings->holiday = $settings->holiday;
                $agentSettings->work_shift = $settings->work_shift;
                $agentSettings->save();
            }
        }
        if (array_key_exists('team_id', $data)) {
            $user->setTeam($data['team_id']);
        }
        if (array_key_exists('password', $data)) {
            $user->setPassword($data['password']);
        }

        if (array_key_exists('type', $data) && $data['type'] == UserType::ASSOCIATION) {
            if (array_key_exists('association_id', $data)) {
                $association = Association::whereId($data['association_id'])->first();
                if ($association != null) {
                    $association->user_id = $user->id;
                    $association->save();
                    $association->refresh();
                }

            }
        }

        $user->image = $this->getImage();
        $user->save();
        $user->refresh();

        return $this->showOne($user, FullUserResource::class, __('The user added successfully'));
    }

    /**
     * @throws \Exception
     */
    public function update(User|Model $user, $data): Model|User
    {
        if (array_key_exists('password', $data)) {
            $user->setPassword($data['password']);
        }
        if (array_key_exists('type', $data)) {
            if ($user->type == UserType::AGENT) {
                if ($data['type'] != UserType::AGENT) {
                    $user->type = UserType::CLIENT;
                    $user->team_id = null;
                    $user->location_id = null;
                }
            }

            if ($data['type'] == UserType::ASSOCIATION) {
                if (array_key_exists('association_id', $data)) {
                    $association = Association::whereId($data['association_id'])->first();
                    if ($association != null) {
                        $association->user_id = $user->id;
                        $association->save();
                        $association->refresh();
                    }
                }
            }

        }
        $user->fill($data);
        $image = $this->getImage();
        if (!is_null($image)) {
            User::getDisk()->delete($user->image);
            $user->image = $image;
        }
        $user->save();
        $user->refresh();

        return $user;
    }

    /**
     * @throws \Exception
     */
    protected function getImage()
    {
        if (request()->has('image')) {
            $file = request()->file('image');

            return $this->createFile($file, null, null, User::getDisk());
        }

        return null;
    }

    public function indexRoles(User $user): PaginatedData
    {

        $filters = [
            AllowedFilter::partial('name'),
            AllowedFilter::partial('description'),
            AllowedFilter::partial('id'),
        ];

        $sorts = [
            AllowedSort::field('name'),
            AllowedSort::field('description'),
            AllowedSort::field('id'),
        ];

        return $this->filter($user->roles(), $filters, $sorts);
    }

    public function editRoles($data, User $user)
    {
        if (!is_null($data)) {
            $user->syncRoles($data);

            return $this->responseMessage(__("The user's roles updated successfully."));
        }
    }

    public function profile(): User
    {
        return \Auth::user();
    }

    public function updateUserPermission(User $user, $data): User
    {
        $updateUserPermission = Permission::where('name', '=', PermissionType::UPDATE_USER_PERMISSIONS)->first();
        $dashboardAccessPermission = Permission::where('name', '=', PermissionType::DASHBOARD_ACCESS)->first();
        $user->permissions()->sync([]);
        $userAccesses = UserAccess::where(['user_id' => $user->id, 'country_id' => $data['country_id']])->get();
        foreach ($userAccesses as $userAccess) {
            $user->permissions()->syncWithoutDetaching($userAccess->getAllPermissions()->pluck('id'));
        }
        $user->permissions()->syncWithoutDetaching([$dashboardAccessPermission->id, $updateUserPermission->id]);
        $user->save();
        $user->refresh();

        return $user;
    }

    public function updateAgentSettings(Collection $data): User
    {
        $agent = User::whereId($data->get('agent_id'))->first();
        if ($agent->agentSettings) {
            $agent->agentSettings()->update([
                'tasks_per_day' => $data->get('tasks_per_day'),
                'budget' => $data->get('budget'),
                'start_work' => $data->get('start_work'),
                'finish_work' => $data->get('finish_work'),
                'holiday' => $data->get('holiday'),
                'work_shift' => $data->get('work_shift'),
            ]);
            $agent->save();
        } else {
            $agentSettings = new AgentSettings();
            $agentSettings->agent_id = $data->get('agent_id');
            $agentSettings->tasks_per_day = $data->get('tasks_per_day');
            $agentSettings->budget = $data->get('budget');
            $agentSettings->start_work = $data->get('start_work');
            $agentSettings->finish_work = $data->get('finish_work');
            $agentSettings->holiday = $data->get('holiday');
            $agentSettings->work_shift = $data->get('work_shift');
            $agentSettings->save();
        }
        $agent->refresh();

        return $agent;
    }

    public function updateUserCountry(array $data): JsonResponse
    {
        $user = \Auth::user();
        if ($user)
            if (isset($data['country_id'])) {
                $user->country_id = $data['country_id'];
                $user->save();
                $user->refresh();
            }

        return $this->responseMessage(__('country updated successfully'));
    }
}
