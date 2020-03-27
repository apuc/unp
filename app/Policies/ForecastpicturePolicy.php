<?php

namespace App\Policies;

use \App\User;
use \App\Forecastpicture;

use Illuminate\Auth\Access\HandlesAuthorization;

class ForecastpicturePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Forecastpicture::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Forecastpicture::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Forecastpicture::class, 'create');
    }

    public function read(User $user, Forecastpicture $forecastpicture)
    {
		return permission($user, Forecastpicture::class, 'read');
    }

    public function update(User $user, Forecastpicture $forecastpicture)
    {
		return permission($user, Forecastpicture::class, 'update');
    }

    public function delete(User $user, Forecastpicture $forecastpicture)
    {
		return permission($user, Forecastpicture::class, 'delete');
    }
}
