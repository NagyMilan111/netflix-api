<?php

use app\Http\Middleware\ApiKeyMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AnalyticsController,
    MainApiController,
    AccountController,
    MediaController,
    ProfileController,
    SubscriptionController,
    TokenController,
    ExternalApiController,
    EpisodeController,
    SeriesController,
    ViewingClassificationController,
    ApiKeyController};

// API Routes
Route::any('/api/{endpoint}', [MainApiController::class, 'routeRequest']);

// Account Routes
Route::prefix('account')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::post('/login', [AccountController::class, 'login']);
    Route::post('/register', [AccountController::class, 'register']);
    Route::put('/reset-password', [AccountController::class, 'resetPassword']);
    Route::post('/logout', [AccountController::class, 'logout']);
    Route::put('/block', [AccountController::class, 'blockAccount']);
    Route::delete('/{id}', [AccountController::class, 'deleteProfile'])->whereNumber('id');
    Route::post('/', [AccountController::class, 'addProfile']);
    Route::delete('/delete/{id}', [AccountController::class, 'deleteAccount'])->whereNumber('id');
});

// Media Routes
Route::prefix('media')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::get('/{id}/play', [MediaController::class, 'playMedia'])->whereNumber('id');
    Route::put('/{id}/pause', [MediaController::class, 'pauseMedia'])->whereNumber('id');
    Route::post('/{id}/resume', [MediaController::class, 'resumeMedia'])->whereNumber('id');
});

// Profile Routes
Route::prefix('profile')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::put('/{id}/preferences', [ProfileController::class, 'updatePreferences'])->whereNumber('id');
    Route::get('/{id}/toWatch', [ProfileController::class, 'getToWatchList'])->whereNumber('id');
    Route::put('/{id}/updateWatchList', [ProfileController::class, 'manageWatchList'])->whereNumber('id');
    Route::put('/{id}/updateViewClassifications', [ProfileController::class, 'updateViewClassifications'])->whereNumber('id');
});

// Subscription Routes
Route::prefix('subscription')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::get('/details/{id}', [SubscriptionController::class, 'getSubscriptionDetails'])->whereNumber('id');
    Route::put('/update', [SubscriptionController::class, 'updateSubscription']);
});

// Token Routes
Route::prefix('token')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::post('/generate/{id}', [TokenController::class, 'generateToken'])->whereNumber('id');
    Route::put('/refresh', [TokenController::class, 'refreshToken']);
    Route::delete('/revoke', [TokenController::class, 'revokeToken']);
    Route::get('/validate', [TokenController::class, 'validateToken']);
});

// External API Routes
Route::prefix('external')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::post('/generate-image', [ExternalApiController::class, 'generateImage']);
});

// Episode Routes
Route::prefix('episode')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::get('/', [EpisodeController::class, 'getAllEpisodes']); // List all episodes
    Route::get('/{id}', [EpisodeController::class, 'getEpisodeById'])->whereNumber('id'); // Show a specific episode
    Route::post('/', [EpisodeController::class, 'addNewEpisode']); // Create a new episode
    Route::put('/{id}', [EpisodeController::class, 'updateEpisode'])->whereNumber('id'); // Update an episode
    Route::delete('/{id}', [EpisodeController::class, 'deleteEpisode'])->whereNumber('id'); // Delete an episode
});

//Series routes
Route::prefix('series')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::get('/', [SeriesController::class, 'listAllSeries']);         // List all series
    Route::get('/{id}', [SeriesController::class, 'getSeriesById'])->whereNumber('id');      // Show a specific series
    Route::post('/', [SeriesController::class, 'createNewSeries']);        // Create a new series
    Route::put('/{id}', [SeriesController::class, 'updateSeries'])->whereNumber('id');    // Update an existing series
    Route::delete('/{id}', [SeriesController::class, 'deleteSeries'])->whereNumber('id');      // Delete a series
});

//Analytics routes
Route::prefix('analytics')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::get('/top-ten/{type}/{category}', [AnalyticsController::class, 'topTen']);
    Route::get('/bottom-ten-watched/{category}', [AnalyticsController::class, 'bottomTen']);
    Route::get('/revenue', [AnalyticsController::class, 'getAllRevenue']);
    Route::get('/sort-all-by-views/{category}', [AnalyticsController::class, 'sortAllByViews']);
});

//ViewingClassification routes
Route::prefix('classifications')->middleware(ApiKeyMiddleware::class)->group(function () {
    Route::get('/', [ViewingClassificationController::class, 'getAllClassifications']);         // List all classifications
    Route::get('/{id}', [ViewingClassificationController::class, 'getClassificationById'])->whereNumber('id');      // Show a specific classification
    Route::post('/', [ViewingClassificationController::class, 'addNewClassification']);        // Create a new classification
    Route::put('/{id}', [ViewingClassificationController::class, 'updateClassification'])->whereNumber('id');    // Update an existing classification
    Route::delete('/{id}', [ViewingClassificationController::class, 'deleteClassification'])->whereNumber('id');      // Delete a classification
});

Route::prefix('keys')->group(function () {
    Route::post('/generate', [ApiKeyController::class, 'generate']);
    Route::put('/refresh', [ApiKeyController::class, 'refresh'])->middleware(ApiKeyMiddleware::class);
    Route::delete('/revoke', [ApiKeyController::class, 'revoke'])->middleware(ApiKeyMiddleware::class);
});
