<?php

namespace App\Notifications;

use App\Models\Dashboard\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyRejectionMail extends Notification
{
    use Queueable;

    private $property;
    private $reason;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($property, $reason)
    {
        $this->property = $property;
        $this->reason = $reason;
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
        $user = User::where('id', $user_id)->first();
        return (new MailMessage)
            ->subject('Property Rejection Notification')
            ->view('website.custom-emails.rejection-notification-email-template', [
                'user' => $user,
                'title' => 'Property Rejection On About Pakistan Properties',
                'content1' => "Property",
                'data_id' => $this->property->id,
                'data_title' => $this->property->title,
                'data_status' => 'Rejected',
                'content2' => $this->reason,
                'infoText' => 'Please contact our Admin on info@aboutpakistan.com with agency/property ID to resolve the issue.'
            ]);
    }
}
