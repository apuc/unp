<?php

namespace App\Policies;

use \App\User;
use \App\Bannerimpression;

use Illuminate\Auth\Access\HandlesAuthorization;

class BannerimpressionPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Bannerimpression::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Bannerimpression::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Bannerimpression::class, 'create');
    }

    public function read(User $user, Bannerimpression $bannerimpression)
    {
		return permission($user, Bannerimpression::class, 'read');
    }

    public function update(User $user, Bannerimpression $bannerimpression)
    {
		return permission($user, Bannerimpression::class, 'update');
    }

    public function delete(User $user, Bannerimpression $bannerimpression)
    {
		return permission($user, Bannerimpression::class, 'delete');
    }
}
