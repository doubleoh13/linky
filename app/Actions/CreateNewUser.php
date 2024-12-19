<?php

namespace App\Actions;

use App\Exceptions\UserNotAuthorizedException;
use App\Models\User;
use Lorisleiva\Actions\Concerns\AsObject;

class CreateNewUser
{
    use AsObject;

    /**
     * @throws UserNotAuthorizedException
     */
    public function handle(
        string $name,
        string $email,
        ?string $password = null,
        ?string $googleId = null,
        ?string $googleToken = null,
        ?string $googleRefreshToken = null,
    ) {
        $authorizedUsers = config('auth.authorized_users');

        if (! in_array($email, $authorizedUsers)) {
            throw new UserNotAuthorizedException;
        }

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
            'google_id' => $googleId,
            'google_token' => $googleToken,
            'google_refresh_token' => $googleRefreshToken,
        ]);
    }
}
