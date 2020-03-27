<?php

namespace App\Policies;

use \App\User;
use \App\Benefit;

use Illuminate\Auth\Access\HandlesAuthorization;

class BenefitPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Benefit::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Benefit::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Benefit::class, 'create');
    }

    public function read(User $user, Benefit $benefit)
    {
		return permission($user, Benefit::class, 'read');
    }

    public function update(User $user, Benefit $benefit)
    {
		return permission($user, Benefit::class, 'update');
    }

    public function delete(User $user, Benefit $benefit)
    {
		return permission($user, Benefit::class, 'delete');
    }
}
