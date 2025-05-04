<?php

namespace App\Policies;

use App\Enums\OrderStatus;
use App\Enums\PermissionType;
use App\Enums\UserType;
use App\Models\Order;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OrderPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function viewAny(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::INDEX_ORDER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function create(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::STORE_ORDER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function update(User $user, Order $model): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_ORDER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function updateManyOrders(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_MANY_ORDER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function view(User $user, Order $model): Response
    {
        return $user->checkPermissionTo(PermissionType::SHOW_ORDER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function showCustomerOrder(User $user, Order $order): Response
    {
        return $user->id === $order->customer_id
            ? $this->allow()
            : $this->deny(__('You dont own this order'));
    }

    public function showOrderDetailsByDriver(User $user, Order $order): Response
    {
        return $user->id === $order->agent_id
            ? $this->allow()
            : $this->deny(__('You are not agent this order'));
    }

    public function delete(User $user, Order $model): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_ORDER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function deleteManyOrders(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::DELETE_MANY_ORDER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function getOrdersReport(User $user): Response
    {
        return $user->checkPermissionTo(PermissionType::INDEX_ORDERS_REPORT)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function makeOrderAssigned(User $user, Order $order): Response
    {
        if ($user->type == UserType::ADMIN)
            return $this->allow();

        if (!$user->checkPermissionTo(PermissionType::MAKE_ORDER_ASSIGNED))
            return $this->deny(__('auth.permission_required'));

        if ($order->status != OrderStatus::CREATED)
            return $this->deny(__('You cant change it to this status'));

        return $this->allow();
    }

    public function makeOrderAccepted(User $user, Order $order): Response
    {
        if ($user->type == UserType::ADMIN)
            return $this->allow();

        if ($order->agent_id != $user->id)
            return $this->deny(__('You dont own this order'));

        if ($order->status != OrderStatus::ASSIGNED)
            return $this->deny(__('You cant change it to this status'));

        if ($user->type != UserType::AGENT)
            return $this->deny(__('auth.permission_required'));

        return $this->allow();
    }

    public function makeOrderPostponed(User $user, Order $order): Response
    {
        if ($user->type == UserType::ADMIN)
            return $this->allow();

        if ($order->agent_id != $user->id)
            return $this->deny(__('You dont own this order'));

        if ($order->status != OrderStatus::ACCEPTED)
            return $this->deny(__('You cant change it to this status'));

        if ($user->type != UserType::AGENT)
            return $this->deny(__('auth.permission_required'));

        return $this->allow();
    }

    public function makeOrderDeclined(User $user, Order $order): Response
    {
        if ($user->type == UserType::ADMIN)
            return $this->allow();

        if ($order->status == OrderStatus::POSTPONED)
            return $this->allow();
        if ($order->agent_id != $user->id)
            return $this->deny(__('You dont own this order'));

        if ($order->status != OrderStatus::ASSIGNED)
            return $this->deny(__('You cant change it to this status'));

        if ($user->type != UserType::AGENT)
            return $this->deny(__('auth.permission_required'));

        return $this->allow();
    }

    public function makeOrderCanceled(User $user, Order $order): Response
    {
        if ($user->type == UserType::ADMIN)
            return $this->allow();

        if ($order->status == OrderStatus::POSTPONED)
            return $this->allow();

        if ($order->agent_id != $user->id)
            return $this->deny(__('You dont own this order'));

        if ($user->type != UserType::AGENT)
            return $this->deny(__('auth.permission_required'));

        return $this->allow();
    }

    public function makeOrderDelivering(User $user, Order $order): Response
    {
        if ($user->type == UserType::ADMIN)
            return $this->allow();

        if ($order->status == OrderStatus::POSTPONED)
            return $this->allow();

        if ($user->id != $order->agent_id)
            return $this->deny(__('You dont own this order'));

        if ($order->status != OrderStatus::ACCEPTED)
            return $this->deny(__('You cant change it to this status'));

        if ($user->type != UserType::AGENT)
            return $this->deny(__('auth.permission_required'));

        if (Order::where(['agent_id' => \Auth::id(), 'status' => OrderStatus::DELIVERING])->first())
            return $this->deny(__('You have already order in delivering'));

        return $this->allow();
    }

    public function makeOrderFailed(User $user, Order $order): Response
    {
        if ($user->type == UserType::ADMIN)
            return $this->allow();

        if ($user->id != $order->agent_id)
            return $this->deny(__('You dont own this order'));

        if ($order->status != OrderStatus::DELIVERING)
            return $this->deny(__('You cant change it to this status'));

        if ($user->type != UserType::AGENT)
            return $this->deny(__('auth.permission_required'));

        return $this->allow();
    }

    public function makeOrderSuccessful(User $user, Order $order): Response
    {
        if ($user->type == UserType::ADMIN)
            return $this->allow();

        if ($user->id != $order->agent_id)
            return $this->deny(__('You dont own this order'));

        if ($order->status != OrderStatus::DELIVERING)
            return $this->deny(__('You cant change it to this status'));

        if ($user->type != UserType::AGENT)
            return $this->deny(__('auth.permission_required'));

        return $this->allow();
    }

    public function updateOrderItems(User $user, Order $order): Response
    {
        return $user->checkPermissionTo(PermissionType::UPDATE_ORDER)
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }

    public function storeCustomerOrder(User $user): Response
    {
        return $user->type == UserType::CLIENT
            ? $this->allow()
            : $this->deny(__('auth.permission_required'));
    }
}
