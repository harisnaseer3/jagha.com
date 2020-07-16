<?php

namespace App\Listeners;

use App\Events\NewPropertyActivatedEvent;
use App\Models\Dashboard\User;
use App\Models\Subscriber;
use App\Notifications\Property\PropertyActivatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

class NotifySubscriberListener implements ShouldQueue
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
     * @param object $event
     * @return void
     */
    public function handle($event)
    {
        $users = (new Subscriber)->all();
        Notification::send($users, new PropertyActivatedNotification($event->property));
    }
}
