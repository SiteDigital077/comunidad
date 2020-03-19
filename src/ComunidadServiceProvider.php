<?php

namespace DigitalsiteSaaS\Comunidad;

use Illuminate\Support\ServiceProvider;

/**
* 
*/
class ComunidadServiceProvider extends ServiceProvider
{
	
	 public function register()
	{
		$this->app->bind('comunidad', function($app) {
			return new Comunidad;

		});
	}

	public function boot()
	{
		
		require __DIR__ . '/Http/routes.php';

		$this->loadViewsFrom(__DIR__ . '/../views', 'comunidad');

	}

}

