<?php

namespace App\Notifications\Property;

use App\Models\Property;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyActivatedNotification extends Notification
{
    use Queueable;

    /**
     * @var Property
     */
    protected $property;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//    }
    public function __construct($property)
    {
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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $title = $this->property->title;
        $id = $this->property->id;
//        dd(route('properties.show', $id));

        return (new MailMessage)
            ->subject('A new Property is up!!')
            ->greeting('Hi!')
            ->line("A new Property")
            ->line("{$title}")
            ->line("has been upload on our site.")
            ->action('View Property', route('properties.show', $id));
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
            //
        ];
    }
}
