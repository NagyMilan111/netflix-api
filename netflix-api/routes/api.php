<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainApiController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProfileController;

// Main API routing for dynamic endpoints
Route::any('/api/{endpoint}', [MainApiController::class, 'routeRequest']);

// UserAccountController Routes
Route::prefix('user')->group(function () {
    Route::post('/profile', [UserAccountController::class, 'addProfile']);
    Route::put('/subscription', [UserAccountController::class, 'updateSubscription']);
    Route::get('/watchlist', [UserAccountController::class, 'getWatchHistory']);
    Route::post('/watchlist/add/{mediaId}', [UserAccountController::class, 'manageWatchList']);
    Route::delete('/watchlist/remove/{mediaId}', [UserAccountController::class, 'manageWatchList']);
});

// AccountController Routes
Route::prefix('account')->group(function () {
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/register', [AccountController::class, 'register']);
    Route::post('/reset-password', [AccountController::class, 'resetPassword']);
    Route::post('/block/{id}', [AccountController::class, 'blockAccount']);
});

// TokenController Routes
Route::prefix('token')->group(function () {
    Route::post('/generate', [TokenController::class, 'generateToken']);
    Route::post('/refresh', [TokenController::class, 'refreshToken']);
    Route::post('/revoke', [TokenController::class, 'revokeToken']);
    Route::post('/validate', [TokenController::class, 'validateToken']);
});

// MediaController Routes
Route::prefix('media')->group(function () {
    Route::get('/{id}/play', [MediaController::class, 'playMedia']);
    Route::post('/{id}/pause', [MediaController::class, 'pauseMedia']);
    Route::post('/{id}/resume', [MediaController::class, 'resumeMedia']);
});

// SubscriptionController Routes
Route::prefix('subscription')->group(function () {
    Route::get('/details', [SubscriptionController::class, 'getSubscriptionDetails']);
    Route::put('/update', [SubscriptionController::class, 'updateSubscription']);
});

// ProfileController Routes
Route::prefix('profile')->group(function () {
    Route::post('/', [ProfileController12::class, 'addProfile']);
    Route::put('/preferences', [ProfileController12::class, 'updatePreferences']);
    Route::delete('/{id}', [ProfileController12::class, 'deleteProfile']);
});
?>