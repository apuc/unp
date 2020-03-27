<?php

namespace App\Policies;

use \App\User;
use \App\Posttag;

use Illuminate\Auth\Access\HandlesAuthorization;

class PosttagPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Posttag::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Posttag::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Posttag::class, 'create');
    }

    public function read(User $user, Posttag $posttag)
    {
		return permission($user, Posttag::class, 'read');
    }

    public function update(User $user, Posttag $posttag)
    {
		return permission($user, Posttag::class, 'update');
    }

    public function delete(User $user, Posttag $posttag)
    {
		return permission($user, Posttag::class, 'delete');
    }
}
