<?php

namespace App\Notifications\Customer;

use App\Enums\NotificationType;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\Exceptions\CouldNotSendNotification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private Order $order;

    private string $message;

    private array $messages;

    private string $title;

    private array $titles;

    /**
     *  Create a new notification instance
     *
     * @param Order $order
     * @return void
     */
    public function __construct(Order $order, $message, $messages, $title, $titles)
    {
        $this->order = $order;
        $this->message = $message;
        $this->messages = $messages;
        $this->title = $title;
        $this->titles = $titles;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class];
    }

    /**
     * @param $notifiable
     * @return FcmMessage
     *
     * @throws CouldNotSendNotification
     */
    public function toFcm($notifiable): FcmMessage
    {
        $data = [
            'type' => (string)NotificationType::ORDER_CREATED,
            'customerId' => (string)$this->order->customer_id,
            'orderId' => (string)$this->order->id,
            'orderStatus' => (string)$this->order->status,
        ];
        $data = array_merge($data, $this->messages, $this->titles);

        return FcmMessage::create()
            ->setData($data)
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle($this->title)
                ->setBody($this->message)
            )
            ->setAndroid(
                AndroidConfig::create()
                    ->setFcmOptions(AndroidFcmOptions::create()->setAnalyticsLabel('analytics'))
                    ->setNotification(AndroidNotification::create()->setColor('#0A0A0A'))
            )->setApns(
                ApnsConfig::create()
                    ->setFcmOptions(ApnsFcmOptions::create()->setAnalyticsLabel('analytics_ios'))
            );
    }
}
