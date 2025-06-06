<?php

namespace App\Providers;

use App\Events\AddPropertyInPackageEvent;
use App\Events\ContactAgentEvent;
use App\Events\LogErrorEvent;
use App\Events\NewPropertyActivatedEvent;
use App\Events\NewUserRegisteredEvent;
use App\Events\NotifyAdminOfEditedProperty;
use App\Events\NotifyAdminOfNewProperty;
use App\Events\NotifyAdminOfPackageRequestEvent;
use App\Events\NotifyAdminOfSupportMessage;
use App\Events\NotifyUserofSupportTicket;
use App\Events\NotifyUserPackageStatusChangeEvent;
use App\Events\UserErrorEvent;
use App\Listeners\AddPropertyInPackageListener;
use App\Listeners\AddUserInSubscriberListener;
use App\Listeners\LogErrorListener;
use App\Listeners\NotifyAdminEditProperty;
use App\Listeners\NotifyAdminListener;
use App\Listeners\NotifyPackageEventListener;
use App\Listeners\NotifySubscriberListener;
use App\Listeners\NotifySupportListener;
use App\Listeners\NotifyUserPackageStatusChangeListener;
use App\Listeners\NotifyUserSupportListener;
use App\Listeners\SendMailToAgentListener;
use App\Listeners\UserErrorListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        NewPropertyActivatedEvent::class => [
            NotifySubscriberListener::class,
        ],
        NewUserRegisteredEvent::class => [
            AddUserInSubscriberListener::class
        ],
        ContactAgentEvent::class => [
            SendMailToAgentListener::class
        ],
        NotifyAdminOfNewProperty::class => [
            NotifyAdminListener::class
        ],
        NotifyAdminOfSupportMessage::class => [
            NotifySupportListener::class
        ],
        NotifyUserofSupportTicket::class => [
            NotifyUserSupportListener::class
        ],
        AddPropertyInPackageEvent::class => [
            AddPropertyInPackageListener::class
        ],
        NotifyAdminOfPackageRequestEvent::class => [
            NotifyPackageEventListener::class
        ],
        NotifyUserPackageStatusChangeEvent::class => [
            NotifyUserPackageStatusChangeListener::class
        ],
        NotifyAdminOfEditedProperty::class => [
            NotifyAdminEditProperty::class
        ],
        UserErrorEvent::class => [
            UserErrorListener::class
        ],
        LogErrorEvent::class => [
            LogErrorListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
