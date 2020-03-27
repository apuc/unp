<?php

namespace App\Policies;

use \App\User;
use \App\Forecastcomment;

use Illuminate\Auth\Access\HandlesAuthorization;

class ForecastcommentPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Forecastcomment::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Forecastcomment::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Forecastcomment::class, 'create');
    }

    public function read(User $user, Forecastcomment $forecastcomment)
    {
		return permission($user, Forecastcomment::class, 'read');
    }

    public function update(User $user, Forecastcomment $forecastcomment)
    {
		return permission($user, Forecastcomment::class, 'update');
    }

    public function delete(User $user, Forecastcomment $forecastcomment)
    {
		return permission($user, Forecastcomment::class, 'delete');
    }
}
