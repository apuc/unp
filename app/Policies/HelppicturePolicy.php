<?php

namespace App\Policies;

use \App\User;
use \App\Helppicture;

use Illuminate\Auth\Access\HandlesAuthorization;

class HelppicturePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Helppicture::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Helppicture::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Helppicture::class, 'create');
    }

    public function read(User $user, Helppicture $helppicture)
    {
		return permission($user, Helppicture::class, 'read');
    }

    public function update(User $user, Helppicture $helppicture)
    {
		return permission($user, Helppicture::class, 'update');
    }

    public function delete(User $user, Helppicture $helppicture)
    {
		return permission($user, Helppicture::class, 'delete');
    }
}
