<?php

namespace App\Policies;

use \App\User;
use \App\Team;

use Illuminate\Auth\Access\HandlesAuthorization;

class TeamPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Team::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Team::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Team::class, 'create');
    }

    public function read(User $user, Team $team)
    {
		return permission($user, Team::class, 'read');
    }

    public function update(User $user, Team $team)
    {
		return permission($user, Team::class, 'update');
    }

    public function delete(User $user, Team $team)
    {
		return permission($user, Team::class, 'delete');
    }
}
