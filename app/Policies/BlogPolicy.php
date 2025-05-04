<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Blog;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class BlogPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_BLOG)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_BLOG)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Blog $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_BLOG)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Blog $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_BLOG)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Blog $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_BLOG)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
