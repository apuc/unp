<?php

namespace App\Policies;

use \App\User;
use \App\Role;

use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Role::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Role::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Role::class, 'create');
    }

    public function read(User $user, Role $role)
    {
		return permission($user, Role::class, 'read');
    }

    public function update(User $user, Role $role)
    {
		return permission($user, Role::class, 'update');
    }

    public function delete(User $user, Role $role)
    {
		return permission($user, Role::class, 'delete');
    }
}
