<?php

namespace App\Http\Controllers\OAuth;

use App\Services\Google\GoogleService;

class GoogleRedirectController
{
    public function __invoke(GoogleService $google)
    {
        $authUrl = $google->getAuthUrl();

        return redirect($authUrl);
    }
}
