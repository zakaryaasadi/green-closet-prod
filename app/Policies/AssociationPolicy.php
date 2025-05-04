<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Association;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AssociationPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_ASSOCIATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_ASSOCIATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Association $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_ASSOCIATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Association $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_ASSOCIATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Association $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_ASSOCIATION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function uploadAssociationImage(User $user, Association $association): Response
    {
        return $user->checkPermissionTo(PermissionType::UPLOAD_ASSOCIATION_IMAGES)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function deleteAssociationImages(User $user, Association $association): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_ASSOCIATION_IMAGES)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));

    }
}
