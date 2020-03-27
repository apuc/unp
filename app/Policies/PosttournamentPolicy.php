<?php

namespace App\Policies;

use \App\User;
use \App\Posttournament;

use Illuminate\Auth\Access\HandlesAuthorization;

class PosttournamentPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Posttournament::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Posttournament::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Posttournament::class, 'create');
    }

    public function read(User $user, Posttournament $posttournament)
    {
		return permission($user, Posttournament::class, 'read');
    }

    public function update(User $user, Posttournament $posttournament)
    {
		return permission($user, Posttournament::class, 'update');
    }

    public function delete(User $user, Posttournament $posttournament)
    {
		return permission($user, Posttournament::class, 'delete');
    }
}
