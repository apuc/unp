<?php

namespace App\Policies;

use \App\User;
use \App\Bookmakertext;

use Illuminate\Auth\Access\HandlesAuthorization;

class BookmakertextPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Bookmakertext::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Bookmakertext::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Bookmakertext::class, 'create');
    }

    public function read(User $user, Bookmakertext $bookmakertext)
    {
		return permission($user, Bookmakertext::class, 'read');
    }

    public function update(User $user, Bookmakertext $bookmakertext)
    {
		return permission($user, Bookmakertext::class, 'update');
    }

    public function delete(User $user, Bookmakertext $bookmakertext)
    {
		return permission($user, Bookmakertext::class, 'delete');
    }
}
