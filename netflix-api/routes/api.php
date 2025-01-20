<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    MainApiController,
    AccountController,
    MediaController,
    ProfileController,
    SubscriptionController,
    TokenController,
    ExternalApiController,
    EpisodeController,
    SeriesController
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
    Route::delete('/{id}', [AccountController::class, 'deleteProfile'])->whereNumber('id');
    Route::post('/', [AccountController::class, 'addProfile']);

});

// Media Routes
Route::prefix('media')->group(function () {
    Route::get('/{id}/play', [MediaController::class, 'playMedia'])->whereNumber('id');
    Route::post('/{id}/pause', [MediaController::class, 'pauseMedia'])->whereNumber('id');
    Route::post('/{id}/resume', [MediaController::class, 'resumeMedia'])->whereNumber('id');
});

// Profile Routes
Route::prefix('profile')->group(function () {
    Route::put('/preferences', [ProfileController::class, 'updatePreferences']);
    Route::get('/{id}/toWatch', [ProfileController::class, 'getToWatchList'])->whereNumber('id');
    Route::put('/{id}/updateWatchList', [ProfileController::class, 'manageWatchList'])->whereNumber('id');
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

// External API Routes
Route::prefix('external')->group(function () {
    Route::post('/generate-image', [ExternalApiController::class, 'generateImage']);
});

// Episode Routes
Route::prefix('episodes')->group(function () {
    Route::get('/', [EpisodeController::class, 'index']); // List all episodes
    Route::get('/{id}', [EpisodeController::class, 'show'])->whereNumber('id'); // Show a specific episode
    Route::post('/', [EpisodeController::class, 'store']); // Create a new episode
    Route::put('/{id}', [EpisodeController::class, 'update'])->whereNumber('id'); // Update an episode
    Route::delete('/{id}', [EpisodeController::class, 'destroy'])->whereNumber('id'); // Delete an episode
});

Route::prefix('series')->group(function () {
    Route::get('/', [SeriesController::class, 'index']);         // List all series
    Route::get('/{id}', [SeriesController::class, 'show']);      // Show a specific series
    Route::post('/', [SeriesController::class, 'store']);        // Create a new series
    Route::put('/{id}', [SeriesController::class, 'update']);    // Update an existing series
    Route::delete('/{id}', [SeriesController::class, 'destroy']);// Delete a series
});