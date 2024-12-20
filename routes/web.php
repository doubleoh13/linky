<?php

use App\Actions\TestAction;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OAuth;
use Illuminate\Support\Facades\Route;

Route::webhooks('webhooks/notion', 'notion');
Route::webhooks('webhooks/todoist', 'todoist');
Route::get('/oauth/redirect/google', OAuth\GoogleRedirectController::class)->name('oauth.redirect.google');
Route::get('/oauth/callback', OAuth\CallbackController::class)->name('oauth.callback');

if (app()->environment('local')) {
    Route::get('/test', TestAction::class)->name('test');
}

Route::get('/auth/redirect', [AuthController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [AuthController::class, 'callback'])->name('auth.callback');
