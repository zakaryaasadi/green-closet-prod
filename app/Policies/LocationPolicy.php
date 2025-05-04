<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Location;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LocationPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_LOCATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_LOCATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Location $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_LOCATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Location $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_LOCATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Location $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_LOCATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
