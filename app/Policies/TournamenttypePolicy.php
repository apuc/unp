<?php

namespace App\Policies;

use \App\User;
use \App\Tournamenttype;

use Illuminate\Auth\Access\HandlesAuthorization;

class TournamenttypePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Tournamenttype::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Tournamenttype::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Tournamenttype::class, 'create');
    }

    public function read(User $user, Tournamenttype $tournamenttype)
    {
		return permission($user, Tournamenttype::class, 'read');
    }

    public function update(User $user, Tournamenttype $tournamenttype)
    {
		return permission($user, Tournamenttype::class, 'update');
    }

    public function delete(User $user, Tournamenttype $tournamenttype)
    {
		return permission($user, Tournamenttype::class, 'delete');
    }
}
