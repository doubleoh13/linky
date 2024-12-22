<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Notion\Notion;

class NotionServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(Notion::class, function () {
            return Notion::create(config('services.notion.token'));
        });
    }

    public function boot(): void {}
}
