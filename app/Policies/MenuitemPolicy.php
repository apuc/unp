<?php

namespace App\Policies;

use \App\User;
use \App\Menuitem;

use Illuminate\Auth\Access\HandlesAuthorization;

class MenuitemPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Menuitem::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Menuitem::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Menuitem::class, 'create');
    }

    public function read(User $user, Menuitem $menuitem)
    {
		return permission($user, Menuitem::class, 'read');
    }

    public function update(User $user, Menuitem $menuitem)
    {
		return permission($user, Menuitem::class, 'update');
    }

    public function delete(User $user, Menuitem $menuitem)
    {
		return permission($user, Menuitem::class, 'delete');
    }
}
