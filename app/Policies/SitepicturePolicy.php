<?php

namespace App\Policies;

use \App\User;
use \App\Sitepicture;

use Illuminate\Auth\Access\HandlesAuthorization;

class SitepicturePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Sitepicture::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Sitepicture::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Sitepicture::class, 'create');
    }

    public function read(User $user, Sitepicture $sitepicture)
    {
		return permission($user, Sitepicture::class, 'read');
    }

    public function update(User $user, Sitepicture $sitepicture)
    {
		return permission($user, Sitepicture::class, 'update');
    }

    public function delete(User $user, Sitepicture $sitepicture)
    {
		return permission($user, Sitepicture::class, 'delete');
    }
}
