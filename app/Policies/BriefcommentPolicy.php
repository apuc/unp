<?php

namespace App\Policies;

use \App\User;
use \App\Briefcomment;

use Illuminate\Auth\Access\HandlesAuthorization;

class BriefcommentPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Briefcomment::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Briefcomment::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Briefcomment::class, 'create');
    }

    public function read(User $user, Briefcomment $briefcomment)
    {
		return permission($user, Briefcomment::class, 'read');
    }

    public function update(User $user, Briefcomment $briefcomment)
    {
		return permission($user, Briefcomment::class, 'update');
    }

    public function delete(User $user, Briefcomment $briefcomment)
    {
		return permission($user, Briefcomment::class, 'delete');
    }
}
