<?php

namespace App\Http\Controllers;

use App\Models\Connection;
use App\Models\User;
use App\Support\Enums\ConnectionProvider;
use Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController
{
    public function redirect()
    {
        if (Auth::check()) {
            return redirect('/');
        }

        // This is to make sure we get a refresh token.
        $with = ['access_type' => 'offline'];
        $connection = Connection::where('provider', ConnectionProvider::Google)->first();
        if (blank($connection?->refresh_token)) {
            $with['prompt'] = 'consent';
        }

        return Socialite::driver('google')
            ->with($with)
            ->scopes(config('services.google.scopes', []))
            ->redirect();
    }

    public function callback()
    {
        /** @var \Laravel\Socialite\Two\User $googleUser */
        $googleUser = Socialite::driver('google')->redirectUrl(route('auth.callback'))->user();

        $this->authorize($googleUser->email);

        $user = User::firstOrCreate([
            'email' => $googleUser->email,
        ], [
            'name' => $googleUser->name,
        ]);

        // Delete any other user if a new one was just created. There should only ever be one.
        if ($user->wasRecentlyCreated) {
            User::where('id', '!=', $user->id)->delete();
        }

        $data = array_filter([
            'provider_id' => $googleUser->id,
            'provider_name' => $googleUser->name,
            'provider_email' => $googleUser->email,
            'provider_avatar' => $googleUser->avatar,
            'access_token' => $googleUser->token,
            'expires_at' => now()->addSeconds($googleUser->expiresIn),
            'scopes' => $googleUser->approvedScopes,
        ]);

        if (! blank($googleUser->refreshToken)) {
            $data['refresh_token'] = $googleUser->refreshToken;
        }

        Connection::updateOrCreate([
            'provider' => ConnectionProvider::Google,
        ], $data);

        Auth::login($user);

        return redirect('/');
    }

    private function authorize(string $email): void
    {
        $authorizedEmails = config('auth.authorized_users');

        if (! in_array($email, $authorizedEmails)) {
            abort(403);
        }
    }
}
