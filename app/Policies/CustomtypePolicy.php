<?php

namespace App\Policies;

use \App\User;
use \App\Customtype;

use Illuminate\Auth\Access\HandlesAuthorization;

class CustomtypePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Customtype::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Customtype::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Customtype::class, 'create');
    }

    public function read(User $user, Customtype $customtype)
    {
		return permission($user, Customtype::class, 'read');
    }

    public function update(User $user, Customtype $customtype)
    {
		return permission($user, Customtype::class, 'update');
    }

    public function delete(User $user, Customtype $customtype)
    {
		return permission($user, Customtype::class, 'delete');
    }
}
