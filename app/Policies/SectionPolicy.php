<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Section;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class SectionPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_SECTION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_SECTION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Section $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_SECTION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Section $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_SECTION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Section $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_SECTION)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
