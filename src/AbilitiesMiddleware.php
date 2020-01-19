<?php

namespace Rlgroup\Abilities;

use Rlgroup\Abilities\App\Ability;
use Closure, Route, Cache;

class AbilitiesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // dd($this->getAllActions());
        $action = Route::currentRouteAction();

        if (!in_array($action, $this->getActions())) {
            $this->updateNewAction($action);
        }

        $authAbilities = $this->authAbilities();

        // dd(!in_array($action, $authAbilities));
        // dd(!in_array('*', $authAbilities));

        if (!in_array('*', $authAbilities) && !in_array($action, $authAbilities)) {
            // if (! auth()->user()->isSuperAdmin()) {
                abort(401);
            // }
            // else {
            //     $ability = Ability::where('controller', $action)->first();
            //     auth()->user()->abilities()->attach($ability->id);
            // }
        }

        return $next($request);
    }

    public function authAbilities()
    {
        if(auth()->user()){
            return auth()->user()->getAllAbilities()->keys()->toArray();
        }
        return [];
    }

    public function getActions()
    {
        return Cache::rememberForever('actionsRoute', function() {
            return Ability::select('controller')->get()->pluck('controller')->toArray();
        });
    }

    public function updateNewAction($action)
    {
        // Ability::updateOrCreate(['controller' => $action], []);

        foreach ($this->getAllActions() as $action) {
            Ability::updateOrCreate(['controller' => $action['controller']], ['name' => $action['name']]);
        }

        Cache::forget('actionsRoute');
    }

    public function getAllActions()
    {
        $controllers = [];

        foreach (Route::getRoutes()->getRoutes() as $route)
        {
            $action = $route->getAction();
            if (array_key_exists('controller', $action) && strpos($action['controller'] ,'App\\Http\\Controllers\\Api\\v1\\Admin\\') !== false ) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $controllers[] = [
                    'controller' => $action['controller'],
                    'name' => str_replace('App\\Http\\Controllers\\Api\\v1\\Admin\\', '', $action['controller'])
                ];
            }
        }
        //dd($controllers);
        Cache::forget('actionsRoute');

        return $controllers;
    }
}
