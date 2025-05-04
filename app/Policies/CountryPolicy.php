<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Country;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CountryPolicy
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
        return $this->allow();
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_COUNTRY)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Country $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_COUNTRY)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Country $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_COUNTRY)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Country $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_COUNTRY)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
