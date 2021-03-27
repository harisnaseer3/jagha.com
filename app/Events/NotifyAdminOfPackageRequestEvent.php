<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NotifyAdminOfPackageRequestEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $package;

    public function __construct($package)
    {
        $this->package = $package;
    }


}
