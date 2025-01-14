<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\MainApiController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\TokenController;

// API Routes
Route::any('/api/{endpoint}', [MainApiController::class, 'routeRequest']);

// Account Routes
Route::prefix('account')->group(function () {
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/register', [AccountController::class, 'register']);
    Route::post('/reset-password', [AccountController::class, 'resetPassword']);
    Route::post('/logout', [AccountController::class, 'logout']);
    Route::post('/block/{id}', [AccountController::class, 'blockAccount']);
});

// Media Routes
Route::prefix('media')->group(function () {
    Route::get('/{id}/play', [MediaController::class, 'playMedia'])->middleware('auth:sanctum');
    Route::post('/{id}/pause', [MediaController::class, 'pauseMedia'])->middleware('auth:sanctum');
    Route::post('/{id}/resume', [MediaController::class, 'resumeMedia'])->middleware('auth:sanctum');
});

// Profile Routes
Route::prefix('profile')->group(function () {
    Route::post('/', [ProfileController::class, 'createProfile'])->middleware('auth:sanctum');
    Route::put('/preferences', [ProfileController::class, 'updatePreferences'])->middleware('auth:sanctum');
    Route::delete('/{id}', [ProfileController::class, 'deleteProfile'])->middleware('auth:sanctum');
});

// Subscription Routes
Route::prefix('subscription')->group(function () {
    Route::get('/details', [SubscriptionController::class, 'getSubscriptionDetails'])->middleware('auth:sanctum');
    Route::put('/update', [SubscriptionController::class, 'updateSubscription'])->middleware('auth:sanctum');
});

// Token Routes
Route::prefix('token')->group(function () {
    Route::post('/validate', [TokenController::class, 'validateToken'])->middleware('auth:sanctum');
    Route::post('/generate', [TokenController::class, 'generateToken']);
    Route::post('/revoke', [TokenController::class, 'revokeToken'])->middleware('auth:sanctum');
});