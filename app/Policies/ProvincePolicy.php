<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Province;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ProvincePolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_PROVINCE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_PROVINCE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Province $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_PROVINCE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Province $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_PROVINCE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Province $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_PROVINCE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
