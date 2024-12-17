<?php

use App\Http\Controllers\OAuth;
use Illuminate\Support\Facades\Route;

Route::webhooks('webhooks/todoist', 'todoist');
Route::get('/oauth/callback', OAuth\CallbackController::class)->name('oauth.callback');
