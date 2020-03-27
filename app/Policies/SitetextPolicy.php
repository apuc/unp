<?php

namespace App\Policies;

use \App\User;
use \App\Sitetext;

use Illuminate\Auth\Access\HandlesAuthorization;

class SitetextPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Sitetext::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Sitetext::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Sitetext::class, 'create');
    }

    public function read(User $user, Sitetext $sitetext)
    {
		return permission($user, Sitetext::class, 'read');
    }

    public function update(User $user, Sitetext $sitetext)
    {
		return permission($user, Sitetext::class, 'update');
    }

    public function delete(User $user, Sitetext $sitetext)
    {
		return permission($user, Sitetext::class, 'delete');
    }
}
