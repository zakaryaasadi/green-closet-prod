<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Street;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class StreetPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_STREET)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_STREET)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Street $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_STREET)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Street $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_STREET)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Street $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_STREET)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
