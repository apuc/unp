<?php

namespace App\Policies;

use \App\User;
use \App\Menusection;

use Illuminate\Auth\Access\HandlesAuthorization;

class MenusectionPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Menusection::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Menusection::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Menusection::class, 'create');
    }

    public function read(User $user, Menusection $menusection)
    {
		return permission($user, Menusection::class, 'read');
    }

    public function update(User $user, Menusection $menusection)
    {
		return permission($user, Menusection::class, 'update');
    }

    public function delete(User $user, Menusection $menusection)
    {
		return permission($user, Menusection::class, 'delete');
    }
}
