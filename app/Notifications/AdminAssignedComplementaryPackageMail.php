<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAssignedComplementaryPackageMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    private $package, $user;

    public function __construct($package, $user)
    {
        $this->package = $package;
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
            ->subject('About Pakistan Complementary Package Subscription')
            ->view('website.custom-emails.notification-package-template', [
//                'user_type' => 'Email Administrator',
                'user_type' => 'admin',
                'user' => $this->user,
                'title' => 'About Pakistan Complementary Package Subscription',
                'type' => $this->package->type,

                'content1' => "A Complementary",
                'content2' => "on About Pakistan Properties",
                'infoText' => 'Thank you for using About Pakistan Properties!'
            ]);
    }


}
