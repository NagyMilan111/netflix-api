<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\ProfileController;


// SubscriptionController Routes
Route::prefix('subscription')->group(function () {
    Route::get('/details', [SubscriptionController::class, 'getSubscriptionDetails']);
    Route::put('/update', [SubscriptionController::class, 'updateSubscription']);
    Route::post('/add', [SubscriptionController::class, 'addSubscription']);
});

?>
