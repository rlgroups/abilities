<?php

namespace Rlgroup\Abilities\Controllers;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function user()
    {
        $config = config('abilities');
        $authGuard = $config['auth_guard'] ?? null;

        return [
            'status' => 'ok',
            'user' => $authGuard ? auth()->guard($authGuard)->user()->select(['id', 'email', 'name'])->first() : auth()->user()->select(['id', 'email', 'name'])->first(),
            'abilities' => $authGuard ? auth()->guard($authGuard)->user()->getAllAbilities() : auth()->user()->getAllAbilities(),
        ];
    }
}
