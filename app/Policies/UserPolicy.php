<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_USER) ||
        $user->checkPermissionTo(PermissionType::MANAGE_CLIENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_USER) ||
        $user->checkPermissionTo(PermissionType::MANAGE_CLIENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, User $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_USER) ||
        $user->checkPermissionTo(PermissionType::MANAGE_CLIENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, User $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_USER) ||
        $user->checkPermissionTo(PermissionType::MANAGE_CLIENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, User $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_USER) ||
        $user->checkPermissionTo(PermissionType::MANAGE_CLIENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function viewAnyUserRoles(User $user, User $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_USER_ROLE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function createUserRoles(User $user, User $model): Response
    {
        return $user->checkPermissionTo(PermissionType::EDIT_USER_ROLE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function indexAgents(User $user, User $model): Response
    {
        return $user->checkPermissionTo(PermissionType::INDEX_AGENTS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function updateUserPermission(User $user, User $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_USER_PERMISSIONS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function updateAgentSettings(User $user, User $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_AGENT_SETTINGS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
