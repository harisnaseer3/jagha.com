<?php

namespace App\Notifications;

use App\Models\Dashboard\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PendingPropertyNotification extends Notification
{
    use Queueable;

    protected $property;

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
        $title = $this->property->title;
        $id = $this->property->id;
        $user_id = $this->property->user_id;
        $user = User::where('id',$user_id)->first();

        return (new MailMessage)
            ->view('website.custom-emails.notification-link-template',[
                'user' => $user,
                'title' => 'A new Property is up on About Pakistan Properties!!',
                'content' => "A new Property with ID {$id} and title {$title} has been added on our site.",
                'url' => route('admin-properties-edit', $id),
                'buttonText' => 'Activate Property',
                'infoText'   => 'Thank you for using About Pakistan Properties.'
            ]);

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
