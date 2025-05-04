<?php

namespace App\Listeners\Customer;

use App\Enums\MessageType;
use App\Enums\OrderStatus;
use App\Events\Customer\OrderStatusChangedSendSmsEvent;
use App\Helpers\AppHelper;
use App\Models\Setting;
use App\Traits\SmsService;
use GuzzleHttp\Exception\GuzzleException;
use ipinfo\ipinfo\IPinfoException;

class OrderStatusChangedSendSmsListener
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
     * @param OrderStatusChangedSendSmsEvent $event
     * @return false
     *
     * @throws GuzzleException
     * @throws IPinfoException
     */
    public function handle(OrderStatusChangedSendSmsEvent $event)
    {
        $order = $event->order;
        $settings = Setting::whereCountryId($order->country_id)?->first() ?? Setting::whereCountryId(null)?->first();

        switch ($order->status) {
            case OrderStatus::ACCEPTED:
                $message = AppHelper::getMessage($order, MessageType::ACCEPT_ORDER_MESSAGE);
                if ($message && $settings->sms_to_accepted)
                    SmsService::sendSMS($order->customer->phone, null, $message, null, $order->country_id);

                break;

            case OrderStatus::DECLINE:
                $message = AppHelper::getMessage($order, MessageType::DECLINE_ORDER_MESSAGE);
                if ($message && $settings->sms_to_decline)
                    SmsService::sendSMS($order->customer->phone, null, $message, null, $order->country_id);

                break;

            case OrderStatus::CANCEL:
                $message = AppHelper::getMessage($order, MessageType::CANCEL_ORDER_MESSAGE);
                if ($message && $settings->sms_to_cancel)
                    SmsService::sendSMS($order->customer->phone, null, $message, null, $order->country_id);

                break;

            case OrderStatus::DELIVERING:
                $message = AppHelper::getMessage($order, MessageType::DELIVERING_ORDER_MESSAGE);
                if ($message && $settings->sms_to_delivering)
                    SmsService::sendSMS($order->customer->phone, null, $message, null, $order->country_id);

                break;

            case OrderStatus::FAILED:
                $message = AppHelper::getMessage($order, MessageType::FAILED_ORDER_MESSAGE);
                if ($message && $settings->sms_to_failed)
                    SmsService::sendSMS($order->customer->phone, null, $message, null, $order->country_id);

                break;
        }

        return false;

    }
}
