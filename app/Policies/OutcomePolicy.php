<?php

namespace App\Policies;

use \App\User;
use \App\Outcome;

use Illuminate\Auth\Access\HandlesAuthorization;

class OutcomePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Outcome::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Outcome::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Outcome::class, 'create');
    }

    public function read(User $user, Outcome $outcome)
    {
		return permission($user, Outcome::class, 'read');
    }

    public function update(User $user, Outcome $outcome)
    {
		return permission($user, Outcome::class, 'update');
    }

    public function delete(User $user, Outcome $outcome)
    {
		return permission($user, Outcome::class, 'delete');
    }
}
