<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
    // Ensure the cache service is registered
    $this->app->singleton('cache', function ($app) {
        return $app['cache.store'];
    });  
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
    
   
}
