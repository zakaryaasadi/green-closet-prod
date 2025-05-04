<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Item;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ItemPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_ITEM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_ITEM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Item $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_ITEM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Item $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_ITEM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Item $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_ITEM)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
