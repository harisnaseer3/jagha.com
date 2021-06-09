<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PackageExpiryMail extends Notification
{
    use Queueable;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    protected $package;
    protected $user;
    protected $expiry;

    public function __construct($user, $package, $expiry)
    {
        $this->package = $package;
        $this->user = $user;
        $this->expiry = $expiry;
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
        if ($this->expiry == 1) {

            return (new MailMessage)
                ->view('website.custom-emails.package_expiry_email', [
                    'content1' => 'Your Package',
                    'user' => $this->user->name,
                    'title' => 'Package Expired',
                    'package' => $package,
                    'agency' => $agency,
                    'is_expired' => $this->expiry,
                    'infoText' => 'Thank you for using About Pakistan Properties.'
                ]);
        } else if ($this->expiry == 2) {
            return (new MailMessage)
                ->view('website.custom-emails.package_expiry_email', [
                    'user' => $this->user->name,
                    'title' => 'Package Expiry Email',
                    'package' => $package,
                    'agency' => $agency,
                    'is_expired' => $this->expiry,
                    'url' => route('package.add.properties', $package->id),
                    'infoText' => 'Thank you for using About Pakistan Properties.'
                ]);
        } else if ($this->expiry == 3) {
            return (new MailMessage)
                ->view('website.custom-emails.package_expiry_email', [
                    'user' => $this->user->name,
                    'title' => 'Package Expiry Email',
                    'package' => $package,
                    'agency' => $agency,
                    'is_expired' => $this->expiry,
                    'url' => route('package.add.properties', $package->id),
                    'infoText' => 'Thank you for using About Pakistan Properties.'
                ]);
        }

    }
}
