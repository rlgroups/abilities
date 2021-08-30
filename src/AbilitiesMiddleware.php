<?php

namespace Rlgroup\Abilities;

use Rlgroup\Abilities\Models\Ability;
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
        $action = Route::currentRouteAction();

        if (!in_array($action, $this->getActions())) {
            $this->updateNewAction($action);
        }

        $authAbilities = $this->authAbilities();

        if (!in_array('*', $authAbilities) && !in_array($action, $authAbilities)) {
            abort(403);
        }

        return $next($request);
    }

    public function authAbilities()
    {
        $config = config('abilities');
        $authGuard = $config['auth_guard'] ?? '';

        if($authGuard){
            return auth()->guard($authGuard)->user()->getAllAbilities()->keys()->toArray();
        } else if(auth()->user()){
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
        $allActions = $this->getAllActions();

        foreach ($allActions as $action) {
            Ability::updateOrCreate(['controller' => $action['controller']], ['name' => $action['name']]);
        }

        Cache::forget('actionsRoute');
    }

    public function getAllActions()
    {
        $controllers = [];
        $routes = Route::getRoutes()->getRoutes();

        foreach ($routes as $route)
        {
            $action = $route->getAction();
            if (array_key_exists('controller', $action) && strpos($action['controller'] ,'App\\Http\\Controllers\\Api\\') !== false ) {
                // You can also use explode('@', $action['controller']); here
                // to separate the class name from the method
                $controllers[] = [
                    'controller' => $action['controller'],
                    'name' => str_replace('App\\Http\\Controllers\\Api\\', '', $action['controller'])
                ];
            }
        }
        Cache::forget('actionsRoute');

        return $controllers;
    }
}
