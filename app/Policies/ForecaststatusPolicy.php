<?php

namespace App\Policies;

use \App\User;
use \App\Forecaststatus;

use Illuminate\Auth\Access\HandlesAuthorization;

class ForecaststatusPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Forecaststatus::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Forecaststatus::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Forecaststatus::class, 'create');
    }

    public function read(User $user, Forecaststatus $forecaststatus)
    {
		return permission($user, Forecaststatus::class, 'read');
    }

    public function update(User $user, Forecaststatus $forecaststatus)
    {
		return permission($user, Forecaststatus::class, 'update');
    }

    public function delete(User $user, Forecaststatus $forecaststatus)
    {
		return permission($user, Forecaststatus::class, 'delete');
    }
}
