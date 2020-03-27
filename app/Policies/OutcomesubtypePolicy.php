<?php

namespace App\Policies;

use \App\User;
use \App\Outcomesubtype;

use Illuminate\Auth\Access\HandlesAuthorization;

class OutcomesubtypePolicy
{
	use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

	public function sidebar(User $user)
	{
		return permission($user, Outcomesubtype::class, 'sidebar');
	}

	public function index(User $user)
	{
		return permission($user, Outcomesubtype::class, 'read');
	}

	public function create(User $user)
	{
		return permission($user, Outcomesubtype::class, 'create');
	}

	public function read(User $user, Outcomesubtype $outcomesubtype)
	{
		return permission($user, Outcomesubtype::class, 'read');
	}

	public function update(User $user, Outcomesubtype $outcomesubtype)
	{
		return permission($user, Outcomesubtype::class, 'update');
	}

	public function delete(User $user, Outcomesubtype $outcomesubtype)
	{
		return permission($user, Outcomesubtype::class, 'delete');
	}
}
