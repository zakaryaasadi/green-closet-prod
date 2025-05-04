<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\News;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class NewsPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_NEWS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_NEWS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, News $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_NEWS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, News $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_NEWS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, News $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_NEWS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function uploadNewsImage(User $user, News $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPLOAD_NEWS_IMAGES)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function deleteNewsImages(User $user, News $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_NEWS_IMAGES)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));

    }
}
