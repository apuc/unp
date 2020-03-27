<?php

namespace App\Policies;

use \App\User;
use \App\Sport;

use Illuminate\Auth\Access\HandlesAuthorization;

class SportPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Sport::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Sport::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Sport::class, 'create');
    }

    public function read(User $user, Sport $sport)
    {
		return permission($user, Sport::class, 'read');
    }

    public function update(User $user, Sport $sport)
    {
		return permission($user, Sport::class, 'update');
    }

    public function delete(User $user, Sport $sport)
    {
		return permission($user, Sport::class, 'delete');
    }
}
