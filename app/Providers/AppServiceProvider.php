<?php

namespace App\Providers;

use Blade;
use Event;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use SocialiteProviders\Manager\SocialiteWasCalled;
use SocialiteProviders\Todoist;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();

        FilamentView::registerRenderHook(PanelsRenderHook::AUTH_LOGIN_FORM_AFTER,
            static fn (): ?string => Blade::render('<x-socialite.buttons :show-divider="true"/>'));

        Event::listen(function (SocialiteWasCalled $event) {
            $event->extendSocialite('todoist', Todoist\Provider::class);
        });
    }
}
