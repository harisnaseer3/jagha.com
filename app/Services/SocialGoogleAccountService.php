<?php
namespace App\Services;
use App\Models\SocialGoogleAccount;
use App\Models\Dashboard\User;
use Illuminate\Auth\Events\Verified;
use Laravel\Socialite\Contracts\User as ProviderUser;
class SocialGoogleAccountService
{
    public function createOrGetUser(ProviderUser $providerUser)
    {
        $account = SocialGoogleAccount::whereProvider('google')
            ->whereProviderUserId($providerUser->getId())
            ->first();
        if ($account) {
            return $account->user;
        } else {
            $account = new SocialGoogleAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => 'google'
            ]);
            $user = User::whereEmail($providerUser->getEmail())->first();
            if (!$user) {
                $user = User::create([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'password' => md5(rand(1,10000)),
                ]);
                event(new Verified($user));
            }
            $account->user()->associate($user);
            $account->save();
            return $user;
        }
    }
}
