<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SocialiteController; // Added SocialiteController import

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';

// Socialite Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/auth/google/redirect', [SocialiteController::class, 'redirectToGoogle'])
        ->name('socialite.google.redirect');

    Route::get('/auth/google/callback', [SocialiteController::class, 'handleGoogleCallback'])
        ->middleware(['throttle:6,1']) // Throttle callback requests
        ->name('socialite.google.callback');
});
