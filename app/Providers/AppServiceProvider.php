<?php

namespace App\Providers;

use Blade;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
    }
}
