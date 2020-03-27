<?php

namespace App\Policies;

use \App\User;
use \App\Sitesection;

use Illuminate\Auth\Access\HandlesAuthorization;

class SitesectionPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Sitesection::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Sitesection::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Sitesection::class, 'create');
    }

    public function read(User $user, Sitesection $sitesection)
    {
		return permission($user, Sitesection::class, 'read');
    }

    public function update(User $user, Sitesection $sitesection)
    {
		return permission($user, Sitesection::class, 'update');
    }

    public function delete(User $user, Sitesection $sitesection)
    {
		return permission($user, Sitesection::class, 'delete');
    }
}
