<?php

namespace App\Policies;

use \App\User;
use \App\Noticeban;

use Illuminate\Auth\Access\HandlesAuthorization;

class NoticebanPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Noticeban::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Noticeban::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Noticeban::class, 'create');
    }

    public function read(User $user, Noticeban $noticeban)
    {
		return permission($user, Noticeban::class, 'read');
    }

    public function update(User $user, Noticeban $noticeban)
    {
		return permission($user, Noticeban::class, 'update');
    }

    public function delete(User $user, Noticeban $noticeban)
    {
		return permission($user, Noticeban::class, 'delete');
    }
}
