<?php

namespace App\Policies;

use \App\User;
use \App\Matchstatus;

use Illuminate\Auth\Access\HandlesAuthorization;

class MatchstatusPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Matchstatus::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Matchstatus::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Matchstatus::class, 'create');
    }

    public function read(User $user, Matchstatus $matchstatus)
    {
		return permission($user, Matchstatus::class, 'read');
    }

    public function update(User $user, Matchstatus $matchstatus)
    {
		return permission($user, Matchstatus::class, 'update');
    }

    public function delete(User $user, Matchstatus $matchstatus)
    {
		return permission($user, Matchstatus::class, 'delete');
    }
}
