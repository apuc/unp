<?php

namespace App\Policies;

use \App\User;
use \App\Noticetemplate;

use Illuminate\Auth\Access\HandlesAuthorization;

class NoticetemplatePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Noticetemplate::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Noticetemplate::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Noticetemplate::class, 'create');
    }

    public function read(User $user, Noticetemplate $noticetemplate)
    {
		return permission($user, Noticetemplate::class, 'read');
    }

    public function update(User $user, Noticetemplate $noticetemplate)
    {
		return permission($user, Noticetemplate::class, 'update');
    }

    public function delete(User $user, Noticetemplate $noticetemplate)
    {
		return permission($user, Noticetemplate::class, 'delete');
    }
}
