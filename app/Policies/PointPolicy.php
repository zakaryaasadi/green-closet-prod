<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Point;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PointPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_POINT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_POINT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Point $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_POINT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Point $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_POINT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Point $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_POINT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
