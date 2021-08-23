<?php

namespace App\Services;

use App\Models\SocialFacebookAccount;
use App\Models\Dashboard\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Verified;
use Laravel\Socialite\Contracts\User as ProviderUser;
use Illuminate\Support\Facades\File;

class SocialFacebookAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialFacebookAccount::whereProvider('facebook')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialFacebookAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'facebook'
            ]);
            $email = $providerUser->getEmail();
            $user = '';
            if (isset($email) && $email !== '') {
                $user = User::whereEmail($providerUser->getEmail())->first();
                if (!$user) {
                    $user = User::create([
                        'email' => $providerUser->getEmail(),
                        'name' => $providerUser->getName(),
                        'password' => md5(rand(1, 10000)),
                    ]);
                    event(new Verified($user));
                }

            } else {
                $user = User::create([
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1, 10000)),
                ]);
            }
            $account->user()->associate($user);
            $account->save();
            return $user;

        }
    }
}
