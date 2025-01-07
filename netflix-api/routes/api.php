<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainApiController;
use App\Http\Controllers\UserAccountController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProfileController12; // Updated to match the controller name

// Dynamic endpoint routing for Main API
Route::any('/api/{endpoint}', [MainApiController::class, 'routeRequest']);

// UserAccountController Routes
Route::prefix('user')->group(function () {
    Route::post('/profile', [UserAccountController::class, 'addProfile'])->middleware('auth:sanctum');
    Route::put('/subscription', [UserAccountController::class, 'updateSubscription'])->middleware('auth:sanctum');
    Route::get('/watchlist', [UserAccountController::class, 'getWatchHistory'])->middleware('auth:sanctum');
    Route::post('/watchlist/add/{mediaId}', [UserAccountController::class, 'manageWatchList'])->middleware('auth:sanctum');
    Route::delete('/watchlist/remove/{mediaId}', [UserAccountController::class, 'manageWatchList'])->middleware('auth:sanctum');
});

// AccountController Routes
Route::prefix('account')->group(function () {
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/logout', [AccountController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('/register', [AccountController::class, 'register']);
    Route::post('/reset-password', [AccountController::class, 'resetPassword']);
    Route::post('/block/{id}', [AccountController::class, 'blockAccount'])->middleware('auth:sanctum');
});

// TokenController Routes
Route::prefix('token')->group(function () {
    Route::post('/generate', [TokenController::class, 'generateToken'])->middleware('auth:sanctum');
    Route::post('/refresh', [TokenController::class, 'refreshToken'])->middleware('auth:sanctum');
    Route::post('/revoke', [TokenController::class, 'revokeToken'])->middleware('auth:sanctum');
    Route::post('/validate', [TokenController::class, 'validateToken']);
});

// MediaController Routes
Route::prefix('media')->group(function () {
    Route::get('/{id}/play', [MediaController::class, 'playMedia'])->middleware('auth:sanctum');
    Route::post('/{id}/pause', [MediaController::class, 'pauseMedia'])->middleware('auth:sanctum');
    Route::post('/{id}/resume', [MediaController::class, 'resumeMedia'])->middleware('auth:sanctum');
});

// SubscriptionController Routes
Route::prefix('subscription')->group(function () {
    Route::get('/details', [SubscriptionController::class, 'getSubscriptionDetails'])->middleware('auth:sanctum');
    Route::put('/update', [SubscriptionController::class, 'updateSubscription'])->middleware('auth:sanctum');
});

// ProfileController12 Routes (Updated)
Route::prefix('profile')->group(function () {
    Route::post('/', [ProfileController12::class, 'addProfile'])->middleware('auth:sanctum');
    Route::put('/preferences', [ProfileController12::class, 'updatePreferences'])->middleware('auth:sanctum');
    Route::delete('/{id}', [ProfileController12::class, 'deleteProfile'])->middleware('auth:sanctum');
});
?>