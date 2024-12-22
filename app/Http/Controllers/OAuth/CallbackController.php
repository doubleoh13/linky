<?php

namespace App\Http\Controllers\OAuth;

use App\Exceptions\OAuthAuthenticationFailedException;
use App\Filament\Resources\ConnectionResource;
use App\Models\Connection;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Laravel\Socialite\Two\User;
use Socialite;
use Symfony\Component\HttpFoundation\Response;

class CallbackController
{
    public function __construct() {}

    public function __invoke(Request $request)
    {
        try {
            /** @var User $socialiteUser */
            $socialiteUser = Socialite::driver($request->service)->user();

            $connection = Connection::where('provider', $request->service)
                ->firstOrNew(['provider_id' => $socialiteUser->getId()]);

            $connection->provider = $request->service;
            $connection->provider_email = $socialiteUser->getEmail();
            $connection->provider_name = $socialiteUser->getName();
            $connection->provider_avatar = $socialiteUser->getAvatar();
            $connection->access_token = $socialiteUser->token;
            $connection->scopes = $socialiteUser->approvedScopes;
            if (! blank($socialiteUser->expiresIn)) {
                $connection->expires_at = now()->addSeconds($socialiteUser->expiresIn);
            }

            if (! blank($socialiteUser->refreshToken)) {
                $connection->refresh_token = $socialiteUser->refreshToken;
            }
            $connection->save();

            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Connection saved successfully.',
                    'connection' => $connection,
                ], Response::HTTP_CREATED);
            }

            Notification::make()
                ->title('Connection Saved')
                ->success()
                ->body("Connection for {$connection->provider->getLabel()} ($connection->provider_email) saved successfully.")
                ->send();

            return redirect()->to(ConnectionResource::getUrl());
        } catch (\Throwable $e) {
            throw $e;
            throw new OAuthAuthenticationFailedException($request->service, $e);
        }
    }
}
