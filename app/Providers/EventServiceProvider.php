<?php

namespace App\Providers;

use App\Events\Admin as AdminEvents;
use App\Events\Agent as AgentEvents;
use App\Events\Customer as CustomerEvents;
use App\Listeners\Admin as AdminListeners;
use App\Listeners\Agent as AgentListeners;
use App\Listeners\Customer as CustomerListeners;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        CustomerEvents\OrderStatusChangedEvent::class => [
            CustomerListeners\ChangeOrderStatusListener::class,
        ],
        AgentEvents\OrderStatusChangedEvent::class => [
            AgentListeners\ChangeOrderStatusListener::class,
        ],
        AdminEvents\OrderStatusChangedEvent::class => [
            AdminListeners\ChangeOrderStatusListener::class,
        ],
        AdminEvents\AssociationExpenseRequestEvent::class => [
            AdminListeners\AssociationExpenseRequestListener::class,
        ],
        CustomerEvents\OrderStatusChangedSendSmsEvent::class => [
            CustomerListeners\OrderStatusChangedSendSmsListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return true;
    }
}
