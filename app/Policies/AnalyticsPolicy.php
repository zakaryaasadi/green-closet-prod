<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AnalyticsPolicy
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

    public function analytics(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::ANALYTICS)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
