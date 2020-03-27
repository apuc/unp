<?php

namespace App\Policies;

use \App\User;
use \App\Customgroup;

use Illuminate\Auth\Access\HandlesAuthorization;

class CustomgroupPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Customgroup::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Customgroup::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Customgroup::class, 'create');
    }

    public function read(User $user, Customgroup $customgroup)
    {
		return permission($user, Customgroup::class, 'read');
    }

    public function update(User $user, Customgroup $customgroup)
    {
		return permission($user, Customgroup::class, 'update');
    }

    public function delete(User $user, Customgroup $customgroup)
    {
		return permission($user, Customgroup::class, 'delete');
    }
}
