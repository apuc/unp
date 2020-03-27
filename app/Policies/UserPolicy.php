<?php

namespace App\Policies;

use \App\User;

use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, User::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, User::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, User::class, 'create');
    }

    public function read(User $user, User $record)
    {
		return permission($user, User::class, 'read');
    }

    public function update(User $user, User $record)
    {
		return permission($user, User::class, 'update');
    }

    public function delete(User $user, User $record)
    {
		return permission($user, User::class, 'delete');
    }
}
