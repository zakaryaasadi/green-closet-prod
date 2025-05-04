<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Neighborhood;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class NeighborhoodPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_NEIGHBORHOOD)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_NEIGHBORHOOD)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Neighborhood $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_NEIGHBORHOOD)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Neighborhood $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_NEIGHBORHOOD)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Neighborhood $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_NEIGHBORHOOD)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
