<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            \Illuminate\Contracts\Broadcasting\Factory::class,
            \Illuminate\Broadcasting\BroadcastManager::class
        );
    }

    public function boot()
    {
        Broadcast::routes(['middleware' => ['web', 'auth']]);

        require base_path('routes/channels.php');
    }
}