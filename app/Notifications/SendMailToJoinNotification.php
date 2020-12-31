<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendMailToJoinNotification extends Notification
{
    use Queueable;

    private $agency;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($agency)
    {
        $this->agency = $agency;
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
        $agency_title = $this->agency->title;

        return (new MailMessage)
            ->subject('Agency User Registration!!')
            ->greeting('Greetings!')
            ->line("Agency named {$agency_title} added you as an agent on About Pakistan Properties.")
            ->action('Login Account', route('login'));
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
