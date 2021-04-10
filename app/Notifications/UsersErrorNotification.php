<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UsersErrorNotification extends Notification
{
    use Queueable;

    private $error;

    /**
     * Create a new notification instance.
     *
     * @return void
     */

    private $user;

    public function __construct($error, $user)
    {
        $this->error = $error;
        $this->user = $user;
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
                'title' => 'User Error',
                'user' => 'Email Administrator',
                'error_user' => $this->user,
                'error' => $this->error,
                'infoText' => 'Thank you for using About Pakistan Properties.'
            ]);
    }

}
