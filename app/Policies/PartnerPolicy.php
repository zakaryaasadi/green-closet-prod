<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Partner;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class PartnerPolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_PARTNER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_PARTNER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Partner $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_PARTNER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function showClientPartners(User $user, Partner $partner): Response
    {
        return $user->country_id == $partner->country_id
            ? $this->allow()
            : $this->deny(__('Not belongs to your country'));
    }

    public function update(User $user, Partner $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_PARTNER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Partner $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_PARTNER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
