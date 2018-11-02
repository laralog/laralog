<?php

namespace Laralog\Laralog;

use Illuminate\Support\ServiceProvider;
use Laralog\Laralog\Commands\CreateToken;

class LaralogServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/routes.php');
        
        $this->publishes([
            __DIR__.'/Config/laralog.php' => config_path('laralog.php'),
        ]);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
