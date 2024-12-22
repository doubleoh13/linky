<?php

namespace App\Providers;

use App\Models\Connection;
use App\Services\Google\Config;
use App\Services\Google\GoogleService;
use App\Support\Enums\ConnectionProvider;
use Google\Client;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class GoogleServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(Config::class, function () {
            return new Config(config('services.google'));
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

        $this->app->singleton(
            GoogleService::class,
            function (Application $app) {
                $service = new GoogleService($app->make(Client::class));
                if ($connection = Connection::where('provider', ConnectionProvider::Google)->first()) {
                    $service->setConnection($connection);
                }

                return $service;
            }
        );
    }

    public function boot(): void {}
}
