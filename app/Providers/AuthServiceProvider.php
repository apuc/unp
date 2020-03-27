<?php

namespace App\Providers;

use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
	/**
	 * Register any authentication / authorization services.
	 *
	 * @return void
	 */

	public function boot()
	{
		$this->registerPolicies();

		Passport::routes();

		Gate::define('admin', function ($user) {
			return ($user->role->slug != 'customer');
		});
	}
}
