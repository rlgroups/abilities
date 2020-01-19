<?php

namespace Rlgroup\Abilities;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

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

        /*Relation::morphMap([
            'App\GroupAbility'    => Rlgroup\Abilities\App\GroupAbility::class,
            'App\Ability'    => Rlgroup\Abilities\App\Ability::class,
        ]);*/
        /*$this->app->middleware([
               \Vendor\Package\Middleware\TestMiddleware::class
        ]);*/
    }
}
