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
    ): User {
        $authorizedUsers = config('auth.authorized_users');

        if (! in_array($email, $authorizedUsers)) {
            throw new UserNotAuthorizedException;
        }

        return User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ]);
    }
}
