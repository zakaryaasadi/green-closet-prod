<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ActivityPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_ACTIVITY)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user): Response
    {

        return $user->checkPermissionTo(PermissionType::SHOW_ACTIVITY)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function getOrderLog(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::GET_ORDER_LOG)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function getContainerLog(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::GET_CONTAINER_LOG)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
