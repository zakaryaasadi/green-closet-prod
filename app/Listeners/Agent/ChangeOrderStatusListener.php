<?php

namespace App\Listeners\Agent;

use App\Enums\MessageType;
use App\Enums\OrderStatus;
use App\Events\Agent\OrderStatusChangedEvent;
use App\Helpers\AppHelper;
use App\Models\Language;
use App\Notifications\Agent\OrderAssignedNotification;
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
        $languages = Language::getActive();

        if ($order->status == OrderStatus::ASSIGNED) {

            $messages = [];
            $titles = [];
            foreach ($languages as $language) {
                $messageTranslate = AppHelper::getMessage($order, MessageType::ASSIGNED_ORDER_MESSAGE_AGENT, $language->id);
                if ($messageTranslate) {
                    $messages['body_' . $language->code] = $messageTranslate;
                }
                $titleTranslate = AppHelper::getMessage($order, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE, $language->id);
                if ($titleTranslate) {
                    $titles['title_' . $language->code] = $titleTranslate;
                }
            }

            $message = AppHelper::getMessage($order, MessageType::ASSIGNED_ORDER_MESSAGE);
            $title = AppHelper::getMessage($order, MessageType::ASSIGNED_ORDER_MESSAGE_TITLE);
            if ($message && $title)
                $order->agent->notify(new OrderAssignedNotification($order, $message, $messages, $title, $titles));
        }

        return false;
    }
}
