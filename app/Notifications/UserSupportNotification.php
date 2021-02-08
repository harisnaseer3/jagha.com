<?php

namespace App\Notifications;

use App\Models\Agency;
use App\Models\Dashboard\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\DocBlock\Tags\Property;

class UserSupportNotification extends Notification
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
        $property = '';
        $agency = '';
        if($this->support->inquire_about === 'Property'){
            $id = $this->support->property_id;
            $property = \App\Models\Property::getPropertyById($id);

        }
        else{
            $id = $this->support->agency_id;
            $agency = Agency::getAgencyById($id);

        }

        return (new MailMessage)
            ->view('website.custom-emails.support-email',[
                'user' => ucwords($this->support->user->name),
                'support' => $this->support,
                'content' => "{$this->support->message}",
                'agency' => $agency,
                'property' => $property,
                'user_mail' => 'true'
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
