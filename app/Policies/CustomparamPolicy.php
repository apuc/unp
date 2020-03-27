<?php

namespace App\Policies;

use \App\User;
use \App\Customparam;

use Illuminate\Auth\Access\HandlesAuthorization;

class CustomparamPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Customparam::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Customparam::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Customparam::class, 'create');
    }

    public function read(User $user, Customparam $customparam)
    {
		return permission($user, Customparam::class, 'read');
    }

    public function update(User $user, Customparam $customparam)
    {
		return permission($user, Customparam::class, 'update');
    }

    public function delete(User $user, Customparam $customparam)
    {
		return permission($user, Customparam::class, 'delete');
    }
}
