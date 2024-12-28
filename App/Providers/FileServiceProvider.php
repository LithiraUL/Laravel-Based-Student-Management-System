<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class FileServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('files', function ($app) {
            return new Filesystem();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Additional boot logic if needed
    }
}


