<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
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
        // 'App\Model' => 'App\Policies\ModelPolicy',
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

        VerifyEmail::toMailUsing(function (User $user, string $verificationUrl)
        {
            return (new MailMessage)
                ->view('website.custom-emails.verification-email',[
                    'user' => $user,
                    'verificationUrl' => $verificationUrl
                ]);
        });

    }

}
