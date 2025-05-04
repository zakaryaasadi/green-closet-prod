<?php

namespace App\Listeners\Admin;

use App\Enums\MessageType;
use App\Events\Admin\AssociationExpenseRequestEvent;
use App\Helpers\AppHelper;
use App\Models\Language;
use App\Models\User;
use App\Notifications\Admin\AssociationExpenseRequestNotification;
use Illuminate\Database\Eloquent\Builder;
use ipinfo\ipinfo\IPinfoException;

class AssociationExpenseRequestListener
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
     * @param AssociationExpenseRequestEvent $event
     * @return bool
     *
     * @throws IPinfoException
     */
    public function handle(AssociationExpenseRequestEvent $event): bool
    {
        $expense = $event->expense;
        $country_id = $expense->association->country_id;
        $languages = Language::getActive();
        $messages = [];
        $titles = [];
        foreach ($languages as $language) {
            $messageTranslate = AppHelper::getMessage($expense, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE, $language->id, $country_id);
            if ($messageTranslate) {
                $messages['body_' . $language->code] = $messageTranslate;
            }
            $titleTranslate = AppHelper::getMessage($expense, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE, $language->id, $country_id);
            if ($titleTranslate) {
                $titles['title_' . $language->code] = $titleTranslate;
            }
        }
        $message = AppHelper::getMessage($expense, MessageType::ASSOCIATION_EXPENSES_REQUESTED_MESSAGE);
        $title = AppHelper::getMessage($expense, MessageType::ASSOCIATION_EXPENSES_REQUESTED_TITLE);

        $admins = User::whereHas('userAccess', function (Builder $query) use ($country_id){
            $query->where('country_id', '=', $country_id);
        })->get();
        if ($message && $title)
            foreach ($admins as $admin)
                $admin->notify(new AssociationExpenseRequestNotification($expense, $message, $messages, $title, $titles));


        return false;
    }
}
