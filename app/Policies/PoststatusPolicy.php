<?php

namespace App\Policies;

use \App\User;
use \App\Poststatus;

use Illuminate\Auth\Access\HandlesAuthorization;

class PoststatusPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Poststatus::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Poststatus::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Poststatus::class, 'create');
    }

    public function read(User $user, Poststatus $poststatus)
    {
		return permission($user, Poststatus::class, 'read');
    }

    public function update(User $user, Poststatus $poststatus)
    {
		return permission($user, Poststatus::class, 'update');
    }

    public function delete(User $user, Poststatus $poststatus)
    {
		return permission($user, Poststatus::class, 'delete');
    }
}
