<?php

namespace App\Exceptions;

use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class OAuthAuthenticationFailedException extends RuntimeException
{
    public function __construct(private readonly string $service, ?Throwable $previous = null)
    {
        parent::__construct("Failed to authenticate with $this->service", previous: $previous);
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function render(Request $request): Response
    {
        if ($request->expectsJson()) {
            return response()->json([
                'error' => 'oauth_authentication_failed',
                'message' => "Failed to authenticate with $this->service",
            ], Response::HTTP_UNAUTHORIZED);
        }

        Notification::make()
            ->title("Failed to authenticate with $this->service")
            ->danger()
            ->send();

        return redirect()->back();
    }
}
