<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LogErrorEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $error;
    public $custom_msg;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($error,$custom_msg)
    {
        $this->error = $error;
        $this->custom_msg = $custom_msg;
    }

}
