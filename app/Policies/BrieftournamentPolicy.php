<?php

namespace App\Policies;

use \App\User;
use \App\Brieftournament;

use Illuminate\Auth\Access\HandlesAuthorization;

class BrieftournamentPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Brieftournament::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Brieftournament::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Brieftournament::class, 'create');
    }

    public function read(User $user, Brieftournament $brieftournament)
    {
		return permission($user, Brieftournament::class, 'read');
    }

    public function update(User $user, Brieftournament $brieftournament)
    {
		return permission($user, Brieftournament::class, 'update');
    }

    public function delete(User $user, Brieftournament $brieftournament)
    {
		return permission($user, Brieftournament::class, 'delete');
    }
}
