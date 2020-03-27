<?php

namespace App\Policies;

use \App\User;
use \App\Noticestatus;

use Illuminate\Auth\Access\HandlesAuthorization;

class NoticestatusPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Noticestatus::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Noticestatus::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Noticestatus::class, 'create');
    }

    public function read(User $user, Noticestatus $noticestatus)
    {
		return permission($user, Noticestatus::class, 'read');
    }

    public function update(User $user, Noticestatus $noticestatus)
    {
		return permission($user, Noticestatus::class, 'update');
    }

    public function delete(User $user, Noticestatus $noticestatus)
    {
		return permission($user, Noticestatus::class, 'delete');
    }
}
