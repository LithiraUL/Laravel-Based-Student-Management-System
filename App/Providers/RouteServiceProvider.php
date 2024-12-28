<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/home';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->routes(function () {
            // Register API routes with the 'api' prefix and 'api' middleware
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace) // Optional: set namespace if needed
                ->group(base_path('routes/api.php'));

            // Register web routes with the 'web' middleware
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Define the "api" route group.
     * This can be used for additional customization if necessary.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace) // Optional: set namespace if needed
            ->group(base_path('routes/api.php'));
    }
}
