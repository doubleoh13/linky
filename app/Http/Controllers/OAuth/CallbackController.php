<?php

namespace App\Http\Controllers\OAuth;

use App\Models\Connection;
use App\Services\Google\GoogleService;
use Cache;
use Http;
use Illuminate\Http\Request;

class CallbackController
{
    public function __construct(private GoogleService $google) {}

    public function __invoke(Request $request)
    {
        return match ($request->service) {
            'todoist' => $this->handleTodoist($request),
            'google' => $this->handleGoogle($request),
            default => response()->json(['error' => 'Invalid service.'], 400),
        };
    }

    private function handleTodoist(Request $request)
    {
        $state = $request->query('state');
        $cachedState = Cache::pull('todoist-oauth-state');

        if (! $cachedState || $state !== $cachedState) {
            return response()->json(['error' => 'Invalid state.'], 400);
        }

        $code = $request->query('code');

        $response = Http::asForm()->post('https://todoist.com/oauth/access_token', [
            'client_id' => config('services.todoist.client_id'),
            'client_secret' => config('services.todoist.client_secret'),
            'code' => $code,
        ]);

        if ($response->failed()) {
            return response()->json(['error' => 'Failed to exchange code for access token.'], 500);
        }
        $data = $response->json();

        return response()->json([
            'access_token' => $data['access_token'],
            'message' => 'Access token successfully retrieved. Webhooks are now enabled.',
        ]);
    }

    private function handleGoogle(Request $request)
    {
        if (! $request->has('code')) {
            return response()->json(['error' => 'Missing authorization code.'], 400);
        }

        $authorization = $this->google->authenticate($request->code);

        Connection::updateOrCreate([
            'service_name' => 'google',
        ], [
            'access_token' => $authorization['access_token'],
            'refresh_token' => $authorization['refresh_token'],
            'expires_at' => now()->addSeconds($authorization['expires_in']),
        ]);

        return response()->json(['message' => 'Access token successfully retrieved.']);
    }
}
