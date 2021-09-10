<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;
use App\Models\Dashboard\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Lang;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-users', function ($user) {
            return $user->hasAnyRoles(['super_admin', 'admin', 'property_agent']);
        });

        Gate::define('edit-users', function ($user) {
            return $user->hasRole('super_admin');
        });

        Gate::define('delete-users', function ($user) {
            return $user->hasRole('super_admin');
        });
        Passport::routes();

        VerifyEmail::toMailUsing(function (User $user, string $verificationUrl) {
            if (auth()->guard('api')->check()) {
                $verificationUrl = str_replace('https://property.aboutpakistan.com/', 'https://property.aboutpakistan.com/api/', $verificationUrl);
            }
            return (new MailMessage)
                ->view('website.custom-emails.verification-email-template', [
                    'user' => $user,
                    'title' => 'Verify your email address',
                    'content' => 'Thank you for registering an account on AboutPakistan, before you get started with exploring wonderful places, finding the right property for your stay, or buying yourself a luxury home we just need you to confirm that this is you. Click below to verify your email address:',
                    'verificationUrl' => $verificationUrl,
                    'buttonText' => 'Verify your email',
                    'infoText' => 'If you did not create any account, no further action is required.'
                ]);
        });

    }

}
