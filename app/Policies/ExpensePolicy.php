<?php

namespace App\Policies;

use App\Enums\PermissionType;
use App\Models\Expense;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ExpensePolicy
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
        return $user->checkPermissionTo(PermissionType::INDEX_EXPENSE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_EXPENSE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Expense $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_EXPENSE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Expense $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_EXPENSE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function delete(User $user, Expense $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_EXPENSE)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function indexAssociationExpenses(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::INDEX_ASSOCIATION_EXPENSES)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
