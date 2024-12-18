<?php

use App\Http\Controllers\OAuth;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::webhooks('webhooks/notion', 'notion');
Route::webhooks('webhooks/todoist', 'todoist');
Route::get('/oauth/google', OAuth\GoogleRedirectController::class)->name('oauth.google');
Route::get('/oauth/callback', OAuth\CallbackController::class)->name('oauth.callback');

if (app()->environment('local')) {
    Route::get('/test', TestController::class);
}
