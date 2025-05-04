<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\District;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DistrictPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function viewAny(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::INDEX_DISTRICT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_DISTRICT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, District $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_DISTRICT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, District $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_DISTRICT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, District $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_DISTRICT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
