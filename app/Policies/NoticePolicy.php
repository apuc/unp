<?php

namespace App\Policies;

use \App\User;
use \App\Notice;

use Illuminate\Auth\Access\HandlesAuthorization;

class NoticePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Notice::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Notice::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Notice::class, 'create');
    }

    public function read(User $user, Notice $notice)
    {
		return permission($user, Notice::class, 'read');
    }

    public function update(User $user, Notice $notice)
    {
		return permission($user, Notice::class, 'update');
    }

    public function delete(User $user, Notice $notice)
    {
		return permission($user, Notice::class, 'delete');
    }
}
