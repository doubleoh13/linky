<?php

namespace App\Http\Controllers\OAuth;

use Cache;
use Http;
use Illuminate\Http\Request;

class CallbackController
{
    public function __invoke(Request $request)
    {
        if ($request->service != 'todoist') {
            return response()->json(['error' => 'Invalid service.'], 400);
        }

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
}
