<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainApiController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProfileController;

// Dynamic endpoint routing for Main API
// Make sure this route does not conflict with others
Route::any('/api/{endpoint}', [MainApiController::class, 'routeRequest']);

// UserAccountController Routes
Route::prefix('user')->group(function () {
    // Add profile to the user
    Route::post('/profile', [UserAccountController::class, 'addProfile'])->middleware('auth:sanctum');
    // Update user's subscription
    Route::put('/subscription', [UserAccountController::class, 'updateSubscription'])->middleware('auth:sanctum');
    // Get user's watchlist history
    Route::get('/watchlist', [UserAccountController::class, 'getWatchHistory'])->middleware('auth:sanctum');
    // Add media to the watchlist
    Route::post('/watchlist/add/{mediaId}', [UserAccountController::class, 'manageWatchList'])->middleware('auth:sanctum');
    // Remove media from the watchlist
    Route::delete('/watchlist/remove/{mediaId}', [UserAccountController::class, 'manageWatchList'])->middleware('auth:sanctum');
});

// AccountController Routes
Route::prefix('account')->group(function () {
    // User login route
    Route::post('/login', [AccountController::class, 'login']);
    // User logout route
    Route::post('/logout', [AccountController::class, 'logout'])->middleware('auth:sanctum');
    // User registration route
    Route::post('/register', [AccountController::class, 'register']);
    // Reset password functionality
    Route::post('/reset-password', [AccountController::class, 'resetPassword']);
    // Block a user account (admin functionality)
    Route::post('/block/{id}', [AccountController::class, 'blockAccount'])->middleware('auth:sanctum');
});

// TokenController Routes
Route::prefix('token')->group(function () {
    // Generate a new token
    Route::post('/generate', [TokenController::class, 'generateToken'])->middleware('auth:sanctum');
    // Refresh an existing token
    Route::post('/refresh', [TokenController::class, 'refreshToken'])->middleware('auth:sanctum');
    // Revoke a token
    Route::post('/revoke', [TokenController::class, 'revokeToken'])->middleware('auth:sanctum');
    // Validate a token
    Route::post('/validate', [TokenController::class, 'validateToken']);
});

// MediaController Routes
Route::prefix('media')->group(function () {
    // Play media
    Route::get('/{id}/play', [MediaController::class, 'playMedia'])->middleware('auth:sanctum');
    // Pause media
    Route::post('/{id}/pause', [MediaController::class, 'pauseMedia'])->middleware('auth:sanctum');
    // Resume media
    Route::post('/{id}/resume', [MediaController::class, 'resumeMedia'])->middleware('auth:sanctum');
});

// SubscriptionController Routes
Route::prefix('subscription')->group(function () {
    // Get subscription details
    Route::get('/details', [SubscriptionController::class, 'getSubscriptionDetails'])->middleware('auth:sanctum');
    // Update subscription
    Route::put('/update', [SubscriptionController::class, 'updateSubscription'])->middleware('auth:sanctum');
});

// ProfileController Routes
Route::prefix('profile')->group(function () {
    // Add a user profile
    Route::post('/', [ProfileController::class, 'addProfile'])->middleware('auth:sanctum');
    // Update user preferences
    Route::put('/preferences', [ProfileController::class, 'updatePreferences'])->middleware('auth:sanctum');
    // Delete a user profile
    Route::delete('/{id}', [ProfileController::class, 'deleteProfile'])->middleware('auth:sanctum');
});

?>