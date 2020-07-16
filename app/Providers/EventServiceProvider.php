<?php

namespace App\Providers;

use App\Events\ContactAgentEvent;
use App\Events\NewPropertyActivatedEvent;
use App\Events\NewUserRegisteredEvent;
use App\Listeners\AddUserInSubscriberListener;
use App\Listeners\NotifySubscriberListener;
use App\Listeners\SendMailToAgentListener;
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
