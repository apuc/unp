<?php

namespace App\Policies;

use \App\User;
use \App\Gender;

use Illuminate\Auth\Access\HandlesAuthorization;

class GenderPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Gender::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Gender::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Gender::class, 'create');
    }

    public function read(User $user, Gender $gender)
    {
		return permission($user, Gender::class, 'read');
    }

    public function update(User $user, Gender $gender)
    {
		return permission($user, Gender::class, 'update');
    }

    public function delete(User $user, Gender $gender)
    {
		return permission($user, Gender::class, 'delete');
    }
}
