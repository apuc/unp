<?php

namespace App\Policies;

use \App\User;
use \App\Deal;

use Illuminate\Auth\Access\HandlesAuthorization;

class DealPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Deal::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Deal::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Deal::class, 'create');
    }

    public function read(User $user, Deal $deal)
    {
		return permission($user, Deal::class, 'read');
    }

    public function update(User $user, Deal $deal)
    {
		return permission($user, Deal::class, 'update');
    }

    public function delete(User $user, Deal $deal)
    {
		return permission($user, Deal::class, 'delete');
    }
}
