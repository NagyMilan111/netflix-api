<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MainApiController,
    AccountController,
    MediaController,
    ProfileController,
    SubscriptionController,
    TokenController
};

// API Routes
Route::any('/api/{endpoint}', [MainApiController::class, 'routeRequest']);

// Account Routes
Route::prefix('account')->group(function () {
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/register', [AccountController::class, 'register']);
    Route::post('/reset-password', [AccountController::class, 'resetPassword']);
    Route::post('/logout', [AccountController::class, 'logout']);
    Route::post('/block/{id}', [AccountController::class, 'blockAccount'])->whereNumber('id');
});

// Media Routes
Route::prefix('media')->group(function () {
    Route::get('/{id}/play', [MediaController::class, 'playMedia'])->whereNumber('id');
    Route::post('/{id}/pause', [MediaController::class, 'pauseMedia'])->whereNumber('id');
    Route::post('/{id}/resume', [MediaController::class, 'resumeMedia'])->whereNumber('id');
});

// Profile Routes
Route::prefix('profile')->group(function () {
    Route::post('/', [ProfileController::class, 'addProfile']);
    Route::put('/preferences', [ProfileController::class, 'updatePreferences']);
    Route::delete('/{id}', [ProfileController::class, 'deleteProfile'])->whereNumber('id');
});

// Subscription Routes
Route::prefix('subscription')->group(function () {
    Route::get('/details/{userId}', [SubscriptionController::class, 'getSubscriptionDetails']);
    Route::put('/update', [SubscriptionController::class, 'updateSubscription']);
});

// Token Routes
Route::prefix('token')->group(function () {
    Route::post('/generate/{userId}', [TokenController::class, 'generateToken'])->whereNumber('userId');
    Route::put('/refresh', [TokenController::class, 'refreshToken']);
    Route::delete('/revoke', [TokenController::class, 'revokeToken']);
    Route::get('/validate', [TokenController::class, 'validateToken']);
});
