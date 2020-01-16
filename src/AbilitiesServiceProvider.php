<?php

namespace Rlgroup\Abilities;

use Illuminate\Support\ServiceProvider;

class AbilitiesServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/migrations');

        /*$this->app->middleware([
               \Vendor\Package\Middleware\TestMiddleware::class
        ]);*/
    }
}
