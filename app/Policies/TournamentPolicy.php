<?php

namespace App\Policies;

use \App\User;
use \App\Tournament;

use Illuminate\Auth\Access\HandlesAuthorization;

class TournamentPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Tournament::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Tournament::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Tournament::class, 'create');
    }

    public function read(User $user, Tournament $tournament)
    {
		return permission($user, Tournament::class, 'read');
    }

    public function update(User $user, Tournament $tournament)
    {
		return permission($user, Tournament::class, 'update');
    }

    public function delete(User $user, Tournament $tournament)
    {
		return permission($user, Tournament::class, 'delete');
    }
}
