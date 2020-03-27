<?php

namespace App\Policies;

use \App\User;
use \App\Usersocial;

use Illuminate\Auth\Access\HandlesAuthorization;

class UsersocialPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Usersocial::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Usersocial::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Usersocial::class, 'create');
    }

    public function read(User $user, Usersocial $usersocial)
    {
		return permission($user, Usersocial::class, 'read');
    }

    public function update(User $user, Usersocial $usersocial)
    {
		return permission($user, Usersocial::class, 'update');
    }

    public function delete(User $user, Usersocial $usersocial)
    {
		return permission($user, Usersocial::class, 'delete');
    }
}
