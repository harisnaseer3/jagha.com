<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgencyRejectionMail extends Notification
{
    use Queueable;

    private $agency;
    private $reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($agency, $reason)
    {
        $this->agency = $agency;
        $this->reason = $reason;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Notification of Agency Rejection On About Pakistan Properties')
            ->greeting('Greetings!')
            ->line("Agency of ID = {$this->agency->id} titled as {$this->agency->title} and has been rejected by the Admin due to the reason of {$this->reason}.")
            ->line('Please contact our Admin on info@aboutpakistan.com with agency/property ID to resolve the issue.');

    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
