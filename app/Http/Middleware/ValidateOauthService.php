<?php

namespace App\Http\Middleware;

use App\Support\Enums\ConnectionProvider;
use Closure;
use Illuminate\Http\Request;

class ValidateOauthService
{
    public function handle(Request $request, Closure $next)
    {
        $provider = ConnectionProvider::tryFrom($request->service);

        if (! $request->has('service') || is_null($provider) || $provider->isOAuth()) {
            abort(400, 'Invalid or unsupported OAuth service.');
        }

        return $next($request);
    }
}
