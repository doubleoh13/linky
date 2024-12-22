<?php

use App\Actions\TestAction;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OAuth;
use App\Http\Middleware\ValidateOauthService;
use Illuminate\Support\Facades\Route;

Route::webhooks('webhooks/notion', 'notion');
Route::webhooks('webhooks/todoist', 'todoist');
Route::webhooks('webhooks/google/{event}', 'google-pubsub');

Route::middleware(['auth', ValidateOauthService::class])->group(function () {
    Route::get('/oauth/redirect', OAuth\RedirectController::class)->name('oauth.redirect');
    Route::get('/oauth/callback', OAuth\CallbackController::class)->name('oauth.callback');
});

if (app()->environment('local')) {
    Route::get('/test', TestAction::class)->name('test');
}

Route::get('/auth/redirect', [AuthController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');

Route::redirect('/auth', '/auth/redirect')->name('login');
