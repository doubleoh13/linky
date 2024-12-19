<?php

namespace App\Http\Middleware;

use Closure;
use Context;
use Illuminate\Http\Request;
use Str;

class AddContext
{
    public function handle(Request $request, Closure $next)
    {
        Context::add('url', $request->url());
        Context::add('trace_id', Str::uuid()->toString());

        return $next($request);
    }
}
