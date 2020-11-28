<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RegisterNotification extends Notification
{
    use Queueable;

    private $roles;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($roles)
    {
        $this->roles = $roles;
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
        $role_name = '';
        $roles = $this->roles;
        foreach($roles as $role){
            $role_name .= $role.' ';

        }

        return (new MailMessage)
            ->subject('Invitation to Join About Pakistan Properties!!')
            ->greeting('Greetings!')
            ->line("To become a member of About Pakistan  Property Portal team as $role_name. Click on the following Register button to SignUp on the About Pakistan Property Portal. ")
            ->action('Register', route('register'));
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
