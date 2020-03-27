<?php

namespace App\Policies;

use \App\User;
use \App\Bookmaker;

use Illuminate\Auth\Access\HandlesAuthorization;

class BookmakerPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Bookmaker::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Bookmaker::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Bookmaker::class, 'create');
    }

    public function read(User $user, Bookmaker $bookmaker)
    {
		return permission($user, Bookmaker::class, 'read');
    }

    public function update(User $user, Bookmaker $bookmaker)
    {
		return permission($user, Bookmaker::class, 'update');
    }

    public function delete(User $user, Bookmaker $bookmaker)
    {
		return permission($user, Bookmaker::class, 'delete');
    }
}
