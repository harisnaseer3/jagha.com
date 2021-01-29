<?php

namespace App\Notifications;

use App\Models\Dashboard\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AgencyStatusChangeMail extends Notification
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
        $user_id = $this->agency->user_id;
        $user = User::where('id',$user_id)->first();
        return (new MailMessage)
            ->subject('Agency Status Update Notification')
            ->view('website.custom-emails.notification-email-template',[
                'user' => $user,
                'title' => 'About Pakistan Agency Status Update',
                'content' => "Status of Agency titled {$this->agency->title} and ID {$this->agency->id} has been changed to {$this->agency->status}  on About Pakistan Properties",
                'infoText'   => 'Thank you for using About Pakistan Properties!'
            ]);
    }

}
