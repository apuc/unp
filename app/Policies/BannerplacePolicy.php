<?php

namespace App\Policies;

use \App\User;
use \App\Bannerplace;

use Illuminate\Auth\Access\HandlesAuthorization;

class BannerplacePolicy
{
	use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

	public function sidebar(User $user)
	{
		return permission($user, Bannerplace::class, 'sidebar');
	}

	public function index(User $user)
	{
		return permission($user, Bannerplace::class, 'read');
	}

	public function create(User $user)
	{
		return permission($user, Bannerplace::class, 'create');
	}

	public function read(User $user, Bannerplace $bannerplace)
	{
		return permission($user, Bannerplace::class, 'read');
	}

	public function update(User $user, Bannerplace $bannerplace)
	{
		return permission($user, Bannerplace::class, 'update');
	}

	public function delete(User $user, Bannerplace $bannerplace)
	{
		return permission($user, Bannerplace::class, 'delete');
	}
}
