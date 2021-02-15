<?php

namespace App\Notifications;

use App\Models\Dashboard\User;
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
        $user = User::where('id', $user_id)->first();
        return (new MailMessage)
            ->subject('Agency Rejection Notification')
            ->view('website.custom-emails.rejection-notification-email-template', [
                'user' => $user,
                'title' => 'Agency Rejection On About Pakistan Properties',
                'content1' => "Agency",
                'content2' => "by the Admin due to the reason of {$this->reason}.",
                'data_id' => $this->agency->id,
                'data_title' => $this->agency->title,
                'data_status' => 'Rejected',
                'infoText' => 'Please contact our Admin on info@aboutpakistan.com with agency/property ID to resolve the issue.'
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
