<?php

namespace App\Listeners;

use App\Models\Admin;
use App\Notifications\LogErrorNotification;
use App\Notifications\UsersErrorNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class LogErrorListener implements ShouldQueue
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
        $user = 'rida@cordstones.com';
        $admins = Admin::getAdminByEmail($user);
        Notification::send($admins, new logErrorNotification($event->error,$event->custom_msg));
    }
}
