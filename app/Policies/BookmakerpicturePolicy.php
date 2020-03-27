<?php

namespace App\Policies;

use \App\User;
use \App\Bookmakerpicture;

use Illuminate\Auth\Access\HandlesAuthorization;

class BookmakerpicturePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Bookmakerpicture::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Bookmakerpicture::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Bookmakerpicture::class, 'create');
    }

    public function read(User $user, Bookmakerpicture $bookmakerpicture)
    {
		return permission($user, Bookmakerpicture::class, 'read');
    }

    public function update(User $user, Bookmakerpicture $bookmakerpicture)
    {
		return permission($user, Bookmakerpicture::class, 'update');
    }

    public function delete(User $user, Bookmakerpicture $bookmakerpicture)
    {
		return permission($user, Bookmakerpicture::class, 'delete');
    }
}
