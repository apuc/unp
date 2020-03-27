<?php

namespace App\Policies;

use \App\User;
use \App\Commentstatus;

use Illuminate\Auth\Access\HandlesAuthorization;

class CommentstatusPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Commentstatus::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Commentstatus::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Commentstatus::class, 'create');
    }

    public function read(User $user, Commentstatus $commentstatus)
    {
		return permission($user, Commentstatus::class, 'read');
    }

    public function update(User $user, Commentstatus $commentstatus)
    {
		return permission($user, Commentstatus::class, 'update');
    }

    public function delete(User $user, Commentstatus $commentstatus)
    {
		return permission($user, Commentstatus::class, 'delete');
    }
}
