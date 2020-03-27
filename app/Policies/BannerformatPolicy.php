<?php

namespace App\Policies;

use \App\User;
use \App\Bannerformat;

use Illuminate\Auth\Access\HandlesAuthorization;

class BannerformatPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Bannerformat::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Bannerformat::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Bannerformat::class, 'create');
    }

    public function read(User $user, Bannerformat $bannerformat)
    {
		return permission($user, Bannerformat::class, 'read');
    }

    public function update(User $user, Bannerformat $bannerformat)
    {
		return permission($user, Bannerformat::class, 'update');
    }

    public function delete(User $user, Bannerformat $bannerformat)
    {
		return permission($user, Bannerformat::class, 'delete');
    }
}
