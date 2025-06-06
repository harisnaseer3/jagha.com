<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyAddedInPackage extends Notification
{
    use Queueable;

    private $package;
    private $property;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($property, $package)
    {
        $this->package = $package;
        $this->property = $property;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }


    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'type' => 'package_property',
            'pack_type' => $this->package->type,
            'id' => $this->package->id,
            'status' => $this->package->status,
            'property' => $this->property,
        ];
    }
}
