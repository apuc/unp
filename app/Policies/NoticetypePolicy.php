<?php

namespace App\Policies;

use \App\User;
use \App\Noticetype;

use Illuminate\Auth\Access\HandlesAuthorization;

class NoticetypePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Noticetype::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Noticetype::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Noticetype::class, 'create');
    }

    public function read(User $user, Noticetype $noticetype)
    {
		return permission($user, Noticetype::class, 'read');
    }

    public function update(User $user, Noticetype $noticetype)
    {
		return permission($user, Noticetype::class, 'update');
    }

    public function delete(User $user, Noticetype $noticetype)
    {
		return permission($user, Noticetype::class, 'delete');
    }
}
