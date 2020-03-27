<?php

namespace App\Policies;

use \App\User;
use \App\Postpicture;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostpicturePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Postpicture::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Postpicture::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Postpicture::class, 'create');
    }

    public function read(User $user, Postpicture $postpicture)
    {
		return permission($user, Postpicture::class, 'read');
    }

    public function update(User $user, Postpicture $postpicture)
    {
		return permission($user, Postpicture::class, 'update');
    }

    public function delete(User $user, Postpicture $postpicture)
    {
		return permission($user, Postpicture::class, 'delete');
    }
}
