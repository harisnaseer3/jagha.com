<?php

namespace App\Listeners;

use App\Models\Dashboard\User;
use App\Notifications\PackageStatusChangeMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class NotifyUserPackageStatusChangeListener implements ShouldQueue
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
        $user = User::where('id', '=', $event->package->user_id)->first();
        Notification::send($user, new PackageStatusChangeMail($user,$event->package));
    }
}
