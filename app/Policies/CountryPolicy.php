<?php

namespace App\Policies;

use \App\User;
use \App\Country;

use Illuminate\Auth\Access\HandlesAuthorization;

class CountryPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Country::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Country::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Country::class, 'create');
    }

    public function read(User $user, Country $country)
    {
		return permission($user, Country::class, 'read');
    }

    public function update(User $user, Country $country)
    {
		return permission($user, Country::class, 'update');
    }

    public function delete(User $user, Country $country)
    {
		return permission($user, Country::class, 'delete');
    }
}
