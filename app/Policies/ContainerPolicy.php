<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Container;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ContainerPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_CONTAINER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_CONTAINER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Container $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_CONTAINER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function getContainerDetailsPolicy(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::INDEX_CONTAINER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Container $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_CONTAINER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Container $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_CONTAINER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function getContainersReport(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::INDEX_CONTAINERS_REPORT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
