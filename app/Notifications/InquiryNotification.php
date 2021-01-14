<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InquiryNotification extends Notification
{
    use Queueable;

    protected $data;
    protected $name;
    protected $property;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($data, $name, $property)
    {
        $this->data = $data;
        $this->name = $name;
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
        return (new MailMessage)
            ->view('website.custom-emails.agent-email', [
                'property' => $this->property,
                'data' => $this->data,
                'user' => $this->name,
            ]);
    }

}
