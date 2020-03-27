<?php

namespace App\Policies;

use \App\User;
use \App\Outcometype;

use Illuminate\Auth\Access\HandlesAuthorization;

class OutcometypePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Outcometype::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Outcometype::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Outcometype::class, 'create');
    }

    public function read(User $user, Outcometype $outcometype)
    {
		return permission($user, Outcometype::class, 'read');
    }

    public function update(User $user, Outcometype $outcometype)
    {
		return permission($user, Outcometype::class, 'update');
    }

    public function delete(User $user, Outcometype $outcometype)
    {
		return permission($user, Outcometype::class, 'delete');
    }
}
