<?php

namespace App\Policies;

use \App\User;
use \App\Counter;

use Illuminate\Auth\Access\HandlesAuthorization;

class CounterPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Counter::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Counter::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Counter::class, 'create');
    }

    public function read(User $user, Counter $counter)
    {
		return permission($user, Counter::class, 'read');
    }

    public function update(User $user, Counter $counter)
    {
		return permission($user, Counter::class, 'update');
    }

    public function delete(User $user, Counter $counter)
    {
		return permission($user, Counter::class, 'delete');
    }
}
