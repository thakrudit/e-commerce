<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // RateLimiter::for('web', function (Request $request) {
        //     return Limit::perMinute(2)->by($request->user()?->id ?: $request->ip());
        // });

        // Default web user routes
        Route::middleware('web')
            ->group(base_path('routes/web.php'));

        // Admin routes
        Route::middleware('web')
            ->prefix('admin')
            ->group(base_path('routes/admin.php'));

        // RateLimiter::for('api', function (Request $request) {
        //     return Limit::perMinute(3)->by($request->user()?->id ?: $request->ip());
        // });

        // Route::middleware('api')
        //     ->prefix('api')
        //     ->group(base_path('routes/api.php'));
    }
}
