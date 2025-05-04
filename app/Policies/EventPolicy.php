<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EventPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_EVENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_EVENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Event $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_EVENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Event $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_EVENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Event $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_EVENT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function uploadEventImage(User $user, Event $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPLOAD_EVENT_IMAGES)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function deleteEventsImages(User $user, Event $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_EVENT_IMAGES)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));

    }
}
