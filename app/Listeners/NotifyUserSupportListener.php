<?php

namespace App\Listeners;

use App\Models\Dashboard\User;
use App\Notifications\SupportNotification;
use App\Notifications\UserSupportNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotifyUserSupportListener implements ShouldQueue
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {

        Notification::send($event->user, new UserSupportNotification($event->support));
    }
}
