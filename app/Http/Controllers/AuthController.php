<?php

namespace App\Http\Controllers;

use App\Actions\CreateNewUser;
use App\Models\User;
use Auth;
use Laravel\Socialite\Facades\Socialite;

class AuthController
{
    public function redirect()
    {
        return Socialite::driver('google')->redirectUrl(route('auth.callback'))->redirect();
    }

    public function callback()
    {
        /** @var \Laravel\Socialite\Two\User $googleUser */
        $googleUser = Socialite::driver('google')->redirectUrl(route('auth.callback'))->user();

        $user = User::where('google_id', $googleUser->id)->first();
        $user ??= User::where('email', $googleUser->email)->first();

        $user ??= CreateNewUser::run(
            $googleUser->name,
            $googleUser->email,
            googleId: $googleUser->id,
            googleToken: $googleUser->token,
            googleRefreshToken: $googleUser->refreshToken
        );

        Auth::login($user);

        return redirect('/');
    }
}
