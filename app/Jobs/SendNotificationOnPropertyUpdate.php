<?php

namespace App\Jobs;

use App\Models\Dashboard\User;
use App\Models\Property;
use App\Notifications\PropertyStatusChange;
use App\Notifications\PropertyStatusChangeMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendNotificationOnPropertyUpdate implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $property;

    public function __construct(Property $property)
    {
        $this->property = $property;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::where('id', '=', $this->property->user_id)->first();
        $user->notify(new PropertyStatusChange($this->property));
        Notification::send($user, new PropertyStatusChangeMail($this->property));
    }
}
