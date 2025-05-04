<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Page;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PagePolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_PAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_PAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Page $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_PAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Page $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_PAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Page $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_PAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
