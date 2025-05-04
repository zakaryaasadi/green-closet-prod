<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserAccessPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_USER_ACCESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_USER_ACCESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, UserAccess $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_USER_ACCESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, UserAccess $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_USER_ACCESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, UserAccess $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_USER_ACCESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
