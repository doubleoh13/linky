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

        $user ??= CreateNewUser::run($googleUser->name, $googleUser->email);

        $data = [
            'google_id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
            'google_token' => $googleUser->token,
        ];
        if ($googleUser->refreshToken) {
            $data['google_refresh_token'] = $googleUser->refreshToken;
        }

        $user->update($data);

        Auth::login($user);

        return redirect('/');
    }
}
