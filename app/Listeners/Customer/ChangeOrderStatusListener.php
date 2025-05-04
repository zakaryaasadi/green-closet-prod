<?php

namespace App\Listeners\Customer;

use App\Enums\MessageType;
use App\Enums\OrderStatus;
use App\Events\Customer\OrderStatusChangedEvent;
use App\Helpers\AppHelper;
use App\Models\Language;
use App\Notifications\Customer\OrderAcceptedNotification;
use App\Notifications\Customer\OrderCanceledNotification;
use App\Notifications\Customer\OrderCreatedNotification;
use App\Notifications\Customer\OrderDeclineNotification;
use App\Notifications\Customer\OrderDeliveringNotification;
use App\Notifications\Customer\OrderFailedNotification;
use App\Notifications\Customer\OrderSuccessfulNotification;
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
    public function handle(OrderStatusChangedEvent $event)
    {
        $order = $event->order;
        $languages = Language::getActive();
        switch ($order->status) {
            case OrderStatus::CREATED:
                $messages = [];
                $titles = [];
                foreach ($languages as $language) {
                    $messageTranslate = AppHelper::getMessage($order, MessageType::CREATE_ORDER_MESSAGE, $language->id);
                    if ($messageTranslate) {
                        $messages['body_' . $language->code] = $messageTranslate;
                    }
                    $titleTranslate = AppHelper::getMessage($order, MessageType::CREATE_ORDER_MESSAGE_TITLE, $language->id);
                    if ($titleTranslate) {
                        $titles['title_' . $language->code] = $titleTranslate;
                    }
                }
                $message = AppHelper::getMessage($order, MessageType::CREATE_ORDER_MESSAGE);
                $title = AppHelper::getMessage($order, MessageType::CREATE_ORDER_MESSAGE_TITLE);
                if ($message && $title)
                    $order->customer?->notify(new OrderCreatedNotification($order, $message, $messages, $title, $titles));
                break;

            case OrderStatus::DECLINE:
                $messages = [];
                $titles = [];
                foreach ($languages as $language) {
                    $messageTranslate = AppHelper::getMessage($order, MessageType::DECLINE_ORDER_MESSAGE, $language->id);
                    if ($messageTranslate) {
                        $messages['body_' . $language->code] = $messageTranslate;
                    }
                    $titleTranslate = AppHelper::getMessage($order, MessageType::DECLINE_ORDER_MESSAGE_TITLE, $language->id);
                    if ($titleTranslate) {
                        $titles['title_' . $language->code] = $titleTranslate;
                    }
                }
                $message = AppHelper::getMessage($order, MessageType::DECLINE_ORDER_MESSAGE);
                $title = AppHelper::getMessage($order, MessageType::DECLINE_ORDER_MESSAGE_TITLE);
                if ($message && $title)
                    $order->customer->notify(new OrderDeclineNotification($order, $message, $messages, $title, $titles));
                break;

            case OrderStatus::ACCEPTED:
                $messages = [];
                $titles = [];
                foreach ($languages as $language) {
                    $messageTranslate = AppHelper::getMessage($order, MessageType::ACCEPT_ORDER_MESSAGE, $language->id);
                    if ($messageTranslate) {
                        $messages['body_' . $language->code] = $messageTranslate;
                    }
                    $titleTranslate = AppHelper::getMessage($order, MessageType::ACCEPT_ORDER_MESSAGE_TITLE, $language->id);
                    if ($titleTranslate) {
                        $titles['title_' . $language->code] = $titleTranslate;
                    }
                }
                $message = AppHelper::getMessage($order, MessageType::ACCEPT_ORDER_MESSAGE);
                $title = AppHelper::getMessage($order, MessageType::ACCEPT_ORDER_MESSAGE_TITLE);
                if ($message && $title)
                    $order->customer->notify(new OrderAcceptedNotification($order, $message, $messages, $title, $titles));
                break;

            case OrderStatus::CANCEL:
                $messages = [];
                $titles = [];
                foreach ($languages as $language) {
                    $messageTranslate = AppHelper::getMessage($order, MessageType::CANCEL_ORDER_MESSAGE, $language->id);
                    if ($messageTranslate) {
                        $messages['body_' . $language->code] = $messageTranslate;
                    }
                    $titleTranslate = AppHelper::getMessage($order, MessageType::CANCEL_ORDER_MESSAGE_TITLE, $language->id);
                    if ($titleTranslate) {
                        $titles['title_' . $language->code] = $titleTranslate;
                    }
                }

                $message = AppHelper::getMessage($order, MessageType::CANCEL_ORDER_MESSAGE);
                $title = AppHelper::getMessage($order, MessageType::CANCEL_ORDER_MESSAGE_TITLE);
                if ($message && $title)
                    $order->customer->notify(new OrderCanceledNotification($order, $message, $messages, $title, $titles));
                break;

            case OrderStatus::DELIVERING:
                $messages = [];
                $titles = [];
                foreach ($languages as $language) {
                    $messageTranslate = AppHelper::getMessage($order, MessageType::DELIVERING_ORDER_MESSAGE, $language->id);
                    if ($messageTranslate) {
                        $messages['body_' . $language->code] = $messageTranslate;
                    }
                    $titleTranslate = AppHelper::getMessage($order, MessageType::DELIVERING_ORDER_MESSAGE_TITLE, $language->id);
                    if ($titleTranslate) {
                        $titles['title_' . $language->code] = $titleTranslate;
                    }
                }

                $message = AppHelper::getMessage($order, MessageType::DELIVERING_ORDER_MESSAGE);
                $title = AppHelper::getMessage($order, MessageType::DELIVERING_ORDER_MESSAGE_TITLE);
                if ($message && $title)
                    $order->customer->notify(new OrderDeliveringNotification($order, $message, $messages, $title, $titles));
                break;

            case OrderStatus::FAILED:
                $messages = [];
                $titles = [];
                foreach ($languages as $language) {
                    $messageTranslate = AppHelper::getMessage($order, MessageType::FAILED_ORDER_MESSAGE, $language->id);
                    if ($messageTranslate) {
                        $messages['body_' . $language->code] = $messageTranslate;
                    }
                    $titleTranslate = AppHelper::getMessage($order, MessageType::FAILED_ORDER_MESSAGE_TITLE, $language->id);
                    if ($titleTranslate) {
                        $titles['title_' . $language->code] = $titleTranslate;
                    }
                }
                $message = AppHelper::getMessage($order, MessageType::FAILED_ORDER_MESSAGE);
                $title = AppHelper::getMessage($order, MessageType::FAILED_ORDER_MESSAGE_TITLE);
                if ($message && $title)
                    $order->customer->notify(new OrderFailedNotification($order, $message, $messages, $title, $titles));
                break;

            case OrderStatus::SUCCESSFUL:
                $messages = [];
                $titles = [];
                foreach ($languages as $language) {
                    $messageTranslate = AppHelper::getMessage($order, MessageType::SUCCESSFUL_ORDER_MESSAGE, $language->id);
                    if ($messageTranslate) {
                        $messages['body_' . $language->code] = $messageTranslate;
                    }
                    $titleTranslate = AppHelper::getMessage($order, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE, $language->id);
                    if ($titleTranslate) {
                        $titles['title_' . $language->code] = $titleTranslate;
                    }
                }
                $message = AppHelper::getMessage($order, MessageType::SUCCESSFUL_ORDER_MESSAGE);
                $title = AppHelper::getMessage($order, MessageType::SUCCESSFUL_ORDER_MESSAGE_TITLE);
                if ($message && $title)
                    $order->customer->notify(new OrderSuccessfulNotification($order, $message, $messages, $title, $titles));
                break;
        }

        return false;
    }
}
