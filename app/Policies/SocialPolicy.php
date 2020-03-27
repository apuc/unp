<?php

namespace App\Policies;

use \App\User;
use \App\Social;

use Illuminate\Auth\Access\HandlesAuthorization;

class SocialPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Social::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Social::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Social::class, 'create');
    }

    public function read(User $user, Social $social)
    {
		return permission($user, Social::class, 'read');
    }

    public function update(User $user, Social $social)
    {
		return permission($user, Social::class, 'update');
    }

    public function delete(User $user, Social $social)
    {
		return permission($user, Social::class, 'delete');
    }
}
