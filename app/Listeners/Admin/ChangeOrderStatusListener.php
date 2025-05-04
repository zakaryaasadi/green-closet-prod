<?php

namespace App\Listeners\Admin;

use App\Enums\MessageType;
use App\Enums\OrderStatus;
use App\Enums\UserType;
use App\Events\Admin\OrderStatusChangedEvent;
use App\Helpers\AppHelper;
use App\Models\User;
use App\Notifications\Admin\OrderCanceledNotification;
use App\Notifications\Admin\OrderCreatedNotification;
use App\Notifications\Admin\OrderDeclineNotification;
use App\Notifications\Admin\OrderDeliveringNotification;
use App\Notifications\Admin\OrderFailedNotification;
use App\Notifications\Admin\OrderSuccessfulNotification;
use ipinfo\ipinfo\IPinfoException;

class ChangeOrderStatusListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param OrderStatusChangedEvent $event
     *
     * @throws IPinfoException
     */
    public function handle(OrderStatusChangedEvent $event): bool
    {

        $order = $event->order;
        $admin = User::where(['country_id' => $order->country_id, 'type' => UserType::ADMIN])->first();

        switch ($order->status) {
            case OrderStatus::CREATED:
                $message = AppHelper::getMessage($order, MessageType::CREATE_ORDER_MESSAGE);
                if ($message)
                    $admin->notify(new OrderCreatedNotification($order, $message));
                break;
            case OrderStatus::DECLINE:
                $message = AppHelper::getMessage($order, MessageType::DECLINE_ORDER_MESSAGE);
                if ($message)
                    $admin->notify(new OrderDeclineNotification($order, $message));
                break;

            case OrderStatus::CANCEL:
                $message = AppHelper::getMessage($order, MessageType::CANCEL_ORDER_MESSAGE);
                if ($message)
                    $admin->notify(new OrderCanceledNotification($order, $message));
                break;

            case OrderStatus::DELIVERING:
                $message = AppHelper::getMessage($order, MessageType::DELIVERING_ORDER_MESSAGE);
                if ($message)
                    $admin->notify(new OrderDeliveringNotification($order, $message));
                break;

            case OrderStatus::FAILED:
                $message = AppHelper::getMessage($order, MessageType::FAILED_ORDER_MESSAGE);
                if ($message)
                    $admin->notify(new OrderFailedNotification($order, $message));
                break;

            case OrderStatus::SUCCESSFUL:
                $message = AppHelper::getMessage($order, MessageType::SUCCESSFUL_ORDER_MESSAGE);
                if ($message)
                    $admin->notify(new OrderSuccessfulNotification($order, $message));
                break;
        }

        return false;
    }
}
