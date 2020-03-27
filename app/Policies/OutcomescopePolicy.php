<?php

namespace App\Policies;

use \App\User;
use \App\Outcomescope;

use Illuminate\Auth\Access\HandlesAuthorization;

class OutcomescopePolicy
{
	use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

	public function sidebar(User $user)
	{
		return permission($user, Outcomescope::class, 'sidebar');
	}

	public function index(User $user)
	{
		return permission($user, Outcomescope::class, 'read');
	}

	public function create(User $user)
	{
		return permission($user, Outcomescope::class, 'create');
	}

	public function read(User $user, Outcomescope $outcomescope)
	{
		return permission($user, Outcomescope::class, 'read');
	}

	public function update(User $user, Outcomescope $outcomescope)
	{
		return permission($user, Outcomescope::class, 'update');
	}

	public function delete(User $user, Outcomescope $outcomescope)
	{
		return permission($user, Outcomescope::class, 'delete');
	}
}
