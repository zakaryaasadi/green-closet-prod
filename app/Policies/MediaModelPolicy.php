<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\MediaModel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MediaModelPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_MEDIA_MODEL)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_MEDIA_MODEL)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, MediaModel $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_MEDIA_MODEL)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, MediaModel $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_MEDIA_MODEL)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, MediaModel $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_MEDIA_MODEL)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
