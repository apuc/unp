<?php

namespace App\Policies;

use \App\User;
use \App\Forecast;

use Illuminate\Auth\Access\HandlesAuthorization;

class ForecastPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Forecast::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Forecast::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Forecast::class, 'create');
    }

    public function read(User $user, Forecast $forecast)
    {
		return permission($user, Forecast::class, 'read');
    }

    public function update(User $user, Forecast $forecast)
    {
		return permission($user, Forecast::class, 'update');
    }

    public function delete(User $user, Forecast $forecast)
    {
		return permission($user, Forecast::class, 'delete');
    }
}
