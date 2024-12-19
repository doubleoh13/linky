<?php

namespace App\Providers;

use App\Services\Google\Config;
use Google\Client;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Config::class, function () {
            return new Config(
                config('services.google.client_id'),
                config('services.google.client_secret'),
                config('services.google.redirect')
            );
        });

        $this->app->singleton(Client::class, function (Application $app) {
            $config = $app->make(Config::class);

            $client = new Client;
            $client->setClientId($config->getClientId());
            $client->setClientSecret($config->getClientSecret());
            $client->setRedirectUri($config->getRedirectUri());
            $client->addScope('https://www.googleapis.com/auth/gmail.modify');
            $client->setAccessType('offline');

            return $client;
        });

    }

    public function boot(): void {}
}
