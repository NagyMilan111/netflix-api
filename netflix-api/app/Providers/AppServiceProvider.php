<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB; // Import DB facade
use Illuminate\Support\Facades\Log; // Import Log facade
use Illuminate\Support\Facades\Route; // Import Route facade
use Illuminate\Support\Facades\Vite; // Import Vite facade
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Prefetch assets with Vite
        Vite::prefetch(concurrency: 3);

        // Log database queries
        DB::listen(function ($query) {
            Log::info($query->sql, $query->bindings);
        });
    }

    /**
     * Map the routes for the application.
     */
    public function map()
    {
        $this->mapApiRoutes();
    }

    /**
     * Map API routes.
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace ?? null) // Ensure namespace is handled
            ->group(base_path('routes/api.php'));
    }
}
