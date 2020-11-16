<?php

namespace Rlgroup\Abilities\Controllers;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    public function user()
    {
        return [
            'status' => 'ok',
            'user' => auth()->user()->select(['id', 'email', 'name'])->first(),
            'abilities' => auth()->user()->getAllAbilities(),
        ];
    }
}
