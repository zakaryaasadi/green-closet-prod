<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Address;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AddressPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_ADDRESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_ADDRESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function updateUserAddress(User $user, Address $address): Response
    {
        return $user->id === $address->user_id
            ? $this->allow()
            : $this->deny(__("you don't own this address"));
    }

    public function showUserAddress(User $user, Address $address): Response
    {
        return $user->id === $address->user_id
            ? $this->allow()
            : $this->deny(__("you don't own this address"));
    }

    public function deleteUserAddress(User $user, Address $address): Response
    {
        return $user->id === $address->user_id
            ? $this->allow()
            : $this->deny(__("you don't own this address"));
    }

    public function view(User $user, Address $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_ADDRESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Address $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_ADDRESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Address $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_ADDRESS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
