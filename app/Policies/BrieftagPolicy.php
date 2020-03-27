<?php

namespace App\Policies;

use \App\User;
use \App\Brieftag;

use Illuminate\Auth\Access\HandlesAuthorization;

class BrieftagPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Brieftag::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Brieftag::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Brieftag::class, 'create');
    }

    public function read(User $user, Brieftag $brieftag)
    {
		return permission($user, Brieftag::class, 'read');
    }

    public function update(User $user, Brieftag $brieftag)
    {
		return permission($user, Brieftag::class, 'update');
    }

    public function delete(User $user, Brieftag $brieftag)
    {
		return permission($user, Brieftag::class, 'delete');
    }
}
