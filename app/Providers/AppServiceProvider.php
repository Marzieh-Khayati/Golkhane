<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Broadcast;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register()
    {
        $this->app->singleton('files', function() {
            return new \Illuminate\Filesystem\Filesystem;
        });
        $this->app->singleton('cache', function ($app) {
        return $app->loadComponent('cache', 'Illuminate\Cache\CacheServiceProvider', 'cache');
    });
    
    $this->app->singleton('cache.store', function ($app) {
        return $app['cache']->driver();
    });
    }

    /**
     * Bootstrap any application services.
     */

    public function boot()
    {
        // Broadcast::routes(['middleware' => ['auth']]);
        // require base_path('routes/channels.php');
    }
}
