<?php

namespace App\Providers;

use Http;
use Illuminate\Support\ServiceProvider;

class TodoistServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Http::macro('todoistRest', function () {
            return Http::withToken(config('services.todoist.token'))
                ->baseUrl('https://api.todoist.com/rest/v2/');
        });

        Http::macro('todoistSync', function () {
            return Http::withToken(config('services.todoist.token'))
                ->baseUrl('https://api.todoist.com/sync/v9/');
        });
    }

    public function boot(): void {}
}
