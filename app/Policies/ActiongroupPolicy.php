<?php

namespace App\Policies;

use \App\User;
use \App\Actiongroup;

use Illuminate\Auth\Access\HandlesAuthorization;

class ActiongroupPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Actiongroup::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Actiongroup::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Actiongroup::class, 'create');
    }

    public function read(User $user, Actiongroup $actiongroup)
    {
		return permission($user, Actiongroup::class, 'read');
    }

    public function update(User $user, Actiongroup $actiongroup)
    {
		return permission($user, Actiongroup::class, 'update');
    }

    public function delete(User $user, Actiongroup $actiongroup)
    {
		return permission($user, Actiongroup::class, 'delete');
    }
}
