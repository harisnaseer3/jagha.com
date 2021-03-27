<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PackageStatusChangeMail extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $package;
    protected $user;

    public function __construct($user, $package)
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
        $agency = '';
        $package = $this->package;
        if ($package->package_for == 'agency')
            $agency = (new \App\Models\Package)->getAgencyFromPackageID($package->id)->agency_id;
        return (new MailMessage)
            ->view('website.custom-emails.package-email', [
                'user' => $this->user->name,
                'title' => 'Package Status Update',
                'package' => $package,
                'agency' => $agency,
                'infoText' => 'Thank you for using About Pakistan Properties.'
            ]);
    }


}
