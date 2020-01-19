## Abilities ##
**A package in Laravel Abilities controller**


### Installation ###

Install via [composer](http://getcomposer.org) in the root directory of a Laravel 5 application

    composer require rlgroup/laravel-abilities-controllers

migrate

	$ php artisan migrate

Add to Http/Kernel.php in array $middleware

	\Rlgroup\Abilities\AbilitiesMiddleware::class,

Add to user.php

	use Rlgroup\Abilities\UserTrait;  use UserTrait;
