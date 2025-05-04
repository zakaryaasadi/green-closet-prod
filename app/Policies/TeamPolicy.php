<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Team;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TeamPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_TEAM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_TEAM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Team $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_TEAM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Team $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_TEAM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Team $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_TEAM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
