<?php

namespace App\Policies;

use \App\User;
use \App\Dealtype;

use Illuminate\Auth\Access\HandlesAuthorization;

class DealtypePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Dealtype::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Dealtype::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Dealtype::class, 'create');
    }

    public function read(User $user, Dealtype $dealtype)
    {
		return permission($user, Dealtype::class, 'read');
    }

    public function update(User $user, Dealtype $dealtype)
    {
		return permission($user, Dealtype::class, 'update');
    }

    public function delete(User $user, Dealtype $dealtype)
    {
		return permission($user, Dealtype::class, 'delete');
    }
}
