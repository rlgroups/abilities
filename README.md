## Abilities ##
**A package in Laravel Abilities controller**


### Installation ###

Install via [composer](http://getcomposer.org) in the root directory of a Laravel 5 application

    composer require rlgroup/laravel-abilities-controllers

migrate

	$ php artisan migrate
	
run 

	$ php artisan db:seed --class="Rlgroup\\Abilities\\Database\\Seeds\\AbilitiesTableSeeder"

Add to Http/Kernel.php in array $routeMiddleware

	'abilities' => \Rlgroup\Abilities\AbilitiesMiddleware::class,

Any place that needs to be read to check permissions can be used
routeMiddleware abilities


Add to user.php

	use Rlgroup\Abilities\UserTrait;  use UserTrait;


Add on app.js page

	---------------------------------
	import collect from 'collect.js'
	
	Vue.prototype.actionController = (controller, method = null) => {
	  if (app && app.abilitiesUser) {
	    if (method) {
	      return app.abilitiesUser.indexOf(`${controller}@${method}`) > -1 || app.abilitiesUser.indexOf(`*`) > -1
	    } else {
	      // console.log(app.abilitiesUser, app.abilitiesUser.indexOf(`${controller}`))
	      return app.abilitiesUser.filter(r => {
		return r.indexOf(`${controller}`) > -1
	      }).length || app.abilitiesUser.indexOf(`*`) > -1
	    }
	  }

	  return false
	}

	Vue.prototype.actionControllerLeastOne = (controllers, method = null) => {
	  if (app && app.abilitiesUser) {
	    let isCan = collect(controllers).map((controller) => {
	      return app.abilitiesUser.filter(r => {
		return r.indexOf(`${controller}`) > -1
	      }).length > 0 || app.abilitiesUser.indexOf(`*`) > -1
	    }).contains(true);

	    return isCan;
	  }

	  return false;
	}
	-----------------------------
	const app = new Vue({
	  data() {
	    return {
		loading: false,
		 user: {},
		 abilities: []
	     }
	 },
 	computed: {
	      abilitiesUser() {
		return Object.keys(this.abilities)
	      },
	      allAbilitiesUser() {
		return this.abilities
	      }
	    },

	    created () {
		this.$vuetify.rtl = true

		axios.get(`/abilities/user`)
		  .then(response => {
		      if (response.data.status == 'ok') {
			this.user = response.data.user
			this.abilities = response.data.abilities
		      }

		      this.loading = true;
		  }).catch(error => {});
	      },
	});
	------------------------------------------------

And wherever client side testing (VUE) is needed

	actionController (action,method)

