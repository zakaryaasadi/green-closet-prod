<?php

namespace App\Http\API\V1\Repositories\UserAccess;

use App\Enums\AccessLevel;
use App\Enums\PermissionType;
use App\Enums\UserType;
use App\Http\API\V1\Core\PaginatedData;
use App\Http\API\V1\Repositories\BaseRepository;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserAccess;
use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\AllowedSort;

class UserAccessRepository extends BaseRepository
{
    use ApiResponse;

    public function __construct(UserAccess $model)
    {
        parent::__construct($model);
    }

    public function index(): PaginatedData
    {
        $filters = [
            AllowedFilter::exact('id'),
            AllowedFilter::exact('user_id'),
            AllowedFilter::callback('user_name', function (Builder $query, $value) {
                $query->whereHas('user', function ($query) use ($value) {
                    return $query->where('name', 'like', '%' . $value . '%');
                });
            }),
            AllowedFilter::exact('country_id'),
            AllowedFilter::exact('role_id'),
        ];
        $sorts = [
            AllowedSort::field('id'),
            AllowedSort::field('user_id'),
            AllowedSort::field('country_id'),
            AllowedSort::field('role_id'),
            AllowedSort::field('created_at'),
        ];

        return parent::filter(UserAccess::class, $filters, $sorts);
    }

    public function storeAccess($data): Model
    {
        $user = User::whereId($data['user_id'])->first();
        $role = Role::whereId($data['role_id'])->first();
        $user->permissions()->syncWithoutDetaching($role->permissions()->pluck('id'));
        $dashboardAccessPermission = Permission::where('name', '=', PermissionType::DASHBOARD_ACCESS)->first();
        $user->permissions()->syncWithoutDetaching([$dashboardAccessPermission->id]);
        $user->save();
        $user->refresh();

        return $this->store($data);
    }

    public function updateAccess(array $data, UserAccess $userAccess): Model
    {
        if (array_key_exists('role_id', $data)) {
            if ($data['role_id'] != $userAccess->role_id) {
                $userAccess->user->removeRole($data['role_id']);
                $role = Role::whereId($data['role_id'])->first();
                $userAccess->user->assignRole($role);
                $userAccess->user->permissions()->syncWithoutDetaching($role->permissions()->pluck('id'));
                $userAccess->user->save();
                $userAccess->user->refresh();
            }
        }
        if (array_key_exists('user_id', $data)) {
            $userAccess->user->removeRole($userAccess->role_id);
            $userAccess->user->save();
            $userAccess->user->refresh();
        }

        $userAccess->update($data);
        $userAccess->save();
        $userAccess->refresh();

        return $userAccess;
    }

    public function storeUserAccess(Collection $data): UserAccess
    {
        $updateUserPermission = Permission::where('name', '=', PermissionType::UPDATE_USER_PERMISSIONS)->first();
        $dashboardAccessPermission = Permission::where('name', '=', PermissionType::DASHBOARD_ACCESS)->first();
        $userAccess = new UserAccess($data->all());
        $userAccess->save();
        $userAccess->permissions()->attach($data['permission_ids']);
        $userAccess->permissions()->syncWithoutDetaching([$dashboardAccessPermission->id, $updateUserPermission->id]);
        $userAccess->save();
        $userAccess->refresh();

        if ($data->get('access_level') == AccessLevel::AGENT_DRIVER) {
            $user = User::whereId($data->get('user_id'))->first();
            $user->type = UserType::AGENT;
            $user->save();
        }

        return $userAccess;
    }

    public function updateUserAccess(UserAccess $userAccess, Collection $data): UserAccess
    {
        if ($data->has('access_level')) {
            if ($userAccess->access_level == AccessLevel::AGENT_DRIVER) {
                if ($data->get('access_level') != AccessLevel::AGENT_DRIVER) {
                    $userAccess->user->type = UserType::CLIENT;
                    $userAccess->user->team_id = null;
                    $userAccess->user->location_id = null;
                    $userAccess->user->save();
                    $userAccess->user->refresh();
                }
            }
            if ($data->get('access_level') == AccessLevel::AGENT_DRIVER) {
                $userAccess->user->type = UserType::AGENT;
                $userAccess->user->save();
                $userAccess->user->refresh();
            }
        }
        $updateUserPermission = Permission::where('name', '=', PermissionType::UPDATE_USER_PERMISSIONS)->first();
        $dashboardAccessPermission = Permission::where('name', '=', PermissionType::DASHBOARD_ACCESS)->first();
        $userAccess->update($data->all());
        if ($data->has('permission_ids'))
            $userAccess->syncPermissions($data['permission_ids']);
        $userAccess->permissions()->syncWithoutDetaching([$dashboardAccessPermission->id, $updateUserPermission->id]);
        $userAccess->save();
        $userAccess->refresh();

        return $userAccess;
    }

    public function deleteUserAccess(UserAccess $userAccess): JsonResponse
    {
        if ($userAccess->access_level == AccessLevel::AGENT_DRIVER) {
            $userAccess->user->type = UserType::CLIENT;
            $userAccess->user->team_id = null;
            $userAccess->user->location_id = null;
            $userAccess->user->save();
            $userAccess->user->refresh();
        }
        $this->delete($userAccess);

        return $this->responseMessage(__('Access deleted successfully'));
    }
}
