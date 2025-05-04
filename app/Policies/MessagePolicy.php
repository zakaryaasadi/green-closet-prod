<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Message;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MessagePolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_MESSAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_MESSAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Message $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_MESSAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Message $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_MESSAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Message $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_MESSAGE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
