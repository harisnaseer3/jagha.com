<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class PendingPackageNotification extends Notification
{
    use Queueable;

    protected $package;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($package)
    {
        $this->package = $package;
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
        $package = (new \App\Models\Package)->getPackageFromId($this->package);
        if ($package->package_for == 'agency')
            $agency = (new \App\Models\Package)->getAgencyFromPackageID($package->id)->agency_id;
        return (new MailMessage)
            ->view('website.custom-emails.notification-link-template_package', [
                'user' => 'Email administrator',
                'status' => $package->status,
                'title' => 'Request for Property Package',
                'package' => $package,
                'agency' => $agency,
                'content1' => "A new Package",
                'url' => route('admin.package.edit', $this->package),
                'buttonText' => 'Activate Package',
                'infoText' => 'Thank you for using About Pakistan Properties.'
            ]);
    }
}
