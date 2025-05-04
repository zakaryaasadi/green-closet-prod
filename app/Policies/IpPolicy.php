<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\IP;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class IpPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_SETTING)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_SETTING)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, IP $ip): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_SETTING)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, IP $ip): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_SETTING)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, IP $ip): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_SETTING)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
