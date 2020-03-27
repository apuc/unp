<?php

namespace App\Policies;

use \App\User;
use \App\Bannersection;

use Illuminate\Auth\Access\HandlesAuthorization;

class BannersectionPolicy
{
	use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

	public function sidebar(User $user)
	{
		return permission($user, Bannersection::class, 'sidebar');
	}

	public function index(User $user)
	{
		return permission($user, Bannersection::class, 'read');
	}

	public function create(User $user)
	{
		return permission($user, Bannersection::class, 'create');
	}

	public function read(User $user, Bannersection $bannersection)
	{
		return permission($user, Bannersection::class, 'read');
	}

	public function update(User $user, Bannersection $bannersection)
	{
		return permission($user, Bannersection::class, 'update');
	}

	public function delete(User $user, Bannersection $bannersection)
	{
		return permission($user, Bannersection::class, 'delete');
	}
}
