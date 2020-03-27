<?php

namespace App\Policies;

use \App\User;
use \App\Briefpicture;

use Illuminate\Auth\Access\HandlesAuthorization;

class BriefpicturePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Briefpicture::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Briefpicture::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Briefpicture::class, 'create');
    }

    public function read(User $user, Briefpicture $briefpicture)
    {
		return permission($user, Briefpicture::class, 'read');
    }

    public function update(User $user, Briefpicture $briefpicture)
    {
		return permission($user, Briefpicture::class, 'update');
    }

    public function delete(User $user, Briefpicture $briefpicture)
    {
		return permission($user, Briefpicture::class, 'delete');
    }
}
