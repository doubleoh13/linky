<?php

namespace App\Http\Controllers\OAuth;

use Illuminate\Http\Request;
use Socialite;

class RedirectController
{
    public function __invoke(Request $request)
    {
        $request->validate(['service' => ['required', 'in:google,todoist']]);

        return Socialite::driver($request->service)
            ->scopes(config("services.$request->service.scopes", []))
            ->redirect();
    }
}
