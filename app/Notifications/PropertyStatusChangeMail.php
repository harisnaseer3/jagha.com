<?php

namespace App\Notifications;

use App\Models\Dashboard\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyStatusChangeMail extends Notification
{
    use Queueable;

    private $property;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
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
        $user_id = $this->property->user_id;
        $user = User::where('id',$user_id)->first();
        return (new MailMessage)
            ->subject('Property Status Update Notification')
            ->view('website.custom-emails.notification-email-template',[
                'user' => $user,
                'title' => 'About Pakistan Property Status Update',
                'content' => "Status of property titled {$this->property->title} and ID {$this->property->id} has been changed to {$this->property->status} on About Pakistan Properties.",
                'infoText'   => 'Thank you for using About Pakistan Properties!'
            ]);
    }


}
