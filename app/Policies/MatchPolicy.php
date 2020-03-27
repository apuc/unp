<?php

namespace App\Policies;

use \App\User;
use \App\Match;

use Illuminate\Auth\Access\HandlesAuthorization;

class MatchPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Match::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Match::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Match::class, 'create');
    }

    public function read(User $user, Match $match)
    {
		return permission($user, Match::class, 'read');
    }

    public function update(User $user, Match $match)
    {
		return permission($user, Match::class, 'update');
    }

    public function delete(User $user, Match $match)
    {
		return permission($user, Match::class, 'delete');
    }
}
