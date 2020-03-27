<?php

namespace App\Policies;

use \App\User;
use \App\Brief;

use Illuminate\Auth\Access\HandlesAuthorization;

class BriefPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Brief::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Brief::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Brief::class, 'create');
    }

    public function read(User $user, Brief $brief)
    {
		return permission($user, Brief::class, 'read');
    }

    public function update(User $user, Brief $brief)
    {
		return permission($user, Brief::class, 'update');
    }

    public function delete(User $user, Brief $brief)
    {
		return permission($user, Brief::class, 'delete');
    }
}
