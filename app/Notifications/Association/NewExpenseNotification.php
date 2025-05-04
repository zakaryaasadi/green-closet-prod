<?php

namespace App\Notifications\Association;

use App\Enums\NotificationType;
use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\Fcm\FcmChannel;
use NotificationChannels\Fcm\FcmMessage;
use NotificationChannels\Fcm\Resources\AndroidConfig;
use NotificationChannels\Fcm\Resources\AndroidFcmOptions;
use NotificationChannels\Fcm\Resources\AndroidNotification;
use NotificationChannels\Fcm\Resources\ApnsConfig;
use NotificationChannels\Fcm\Resources\ApnsFcmOptions;

class NewExpenseNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $expense;

    private $message;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Expense $expense, $message)
    {
        $this->expense = $expense;
        $this->message = $message;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [FcmChannel::class, 'database'];
    }

    /**
     * @param $notifiable
     * @return FcmMessage
     */
    public function toFcm($notifiable)
    {
        $data = [
            'type' => (string)NotificationType::EXPENSE_CREATED,
            'associationId' => (string)$this->expense->association_id,
            'expenseId' => (string)$this->expense->id,
            'expenseStatus' => (string)$this->expense->status,
        ];

        return FcmMessage::create()
            ->setData($data)
            ->setNotification(\NotificationChannels\Fcm\Resources\Notification::create()
                ->setTitle('Expense (#' . $this->expense->id . ') requested')
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => (string)NotificationType::EXPENSE_CREATED,
            'associationId' => (string)$this->expense->association_id,
            'expenseId' => (string)$this->expense->id,
            'expenseStatus' => (string)$this->expense->status,
        ];
    }
}
