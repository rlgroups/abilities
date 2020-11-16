<?php

//use Illuminate\Http\Request;

Route::group(['prefix' => 'abilities','middleware' => 'auth:api'], function() {
    Route::get('/user', 'Rlgroup\Abilities\Controllers\UsersController@user');
});
