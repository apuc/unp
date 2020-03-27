<?php

namespace App\Policies;

use \App\User;
use \App\Bannerpost;

use Illuminate\Auth\Access\HandlesAuthorization;

class BannerpostPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Bannerpost::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Bannerpost::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Bannerpost::class, 'create');
    }

    public function read(User $user, Bannerpost $bannerpost)
    {
		return permission($user, Bannerpost::class, 'read');
    }

    public function update(User $user, Bannerpost $bannerpost)
    {
		return permission($user, Bannerpost::class, 'update');
    }

    public function delete(User $user, Bannerpost $bannerpost)
    {
		return permission($user, Bannerpost::class, 'delete');
    }
}
