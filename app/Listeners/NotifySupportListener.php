<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Models\Support;
use App\Notifications\SupportNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifySupportListener implements ShouldQueue
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
        $admins =  Admin::getAdminsByRoleName('Emails Administrator');

        Notification::send($admins, new SupportNotification($event->support));
    }
}
