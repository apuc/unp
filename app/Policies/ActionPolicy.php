<?php

namespace App\Policies;

use \App\User;
use \App\Action;

use Illuminate\Auth\Access\HandlesAuthorization;

class ActionPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Action::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Action::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Action::class, 'create');
    }

    public function read(User $user, Action $action)
    {
		return permission($user, Action::class, 'read');
    }

    public function update(User $user, Action $action)
    {
		return permission($user, Action::class, 'update');
    }

    public function delete(User $user, Action $action)
    {
		return permission($user, Action::class, 'delete');
    }
}
