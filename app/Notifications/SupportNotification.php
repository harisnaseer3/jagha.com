<?php

namespace App\Notifications;

use App\Models\Dashboard\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportNotification extends Notification
{
    use Queueable;
    protected $support;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($support)
    {
        $this->support = $support;
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
        $user_id = $this->support->user_id;
        $user = User::where('id',$user_id)->first();
        if($this->support->inquire_about === 'Property'){
            $id = $this->support->property_id;
        }
        else{
            $id = $this->support->agency_id;

        }

        return (new MailMessage)
            ->view('website.custom-emails.notification-email-template',[
                'user' => $user,
                'title' => 'A new Support Ticket',
                'content' => "{$this->support->message}",
                'infoText'   => 'Thank you for using About Pakistan Properties.'
            ]);
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
