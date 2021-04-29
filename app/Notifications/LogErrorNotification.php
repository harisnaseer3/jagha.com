<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class LogErrorNotification extends Notification
{
    use Queueable;

    private $error;
    private $custom_msg;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($error, $custom_msg)
    {
        $this->error = $error;
        $this->custom_msg = $custom_msg;
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
            ->view('website.custom-emails.user-error-template', [
                'title' => 'Log Error',
                'user' => 'Email Administrator',

                'error' => $this->error,
                'custom_msg' => $this->custom_msg,
                'infoText' => 'Thank you for using About Pakistan Properties.'
            ]);
    }


}
