<?php

namespace App\Policies;

use \App\User;
use \App\Banner;

use Illuminate\Auth\Access\HandlesAuthorization;

class BannerPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Banner::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Banner::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Banner::class, 'create');
    }

    public function read(User $user, Banner $banner)
    {
		return permission($user, Banner::class, 'read');
    }

    public function update(User $user, Banner $banner)
    {
		return permission($user, Banner::class, 'update');
    }

    public function delete(User $user, Banner $banner)
    {
		return permission($user, Banner::class, 'delete');
    }
}
