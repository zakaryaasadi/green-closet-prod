<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\LocationSettings;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class LocationSettingsPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function viewAny(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::INDEX_LOCATION_SETTINGS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_LOCATION_SETTINGS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, LocationSettings $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_LOCATION_SETTINGS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, LocationSettings $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_LOCATION_SETTINGS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, LocationSettings $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_LOCATION_SETTINGS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
