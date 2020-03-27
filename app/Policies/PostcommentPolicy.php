<?php

namespace App\Policies;

use \App\User;
use \App\Postcomment;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostcommentPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Postcomment::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Postcomment::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Postcomment::class, 'create');
    }

    public function read(User $user, Postcomment $postcomment)
    {
		return permission($user, Postcomment::class, 'read');
    }

    public function update(User $user, Postcomment $postcomment)
    {
		return permission($user, Postcomment::class, 'update');
    }

    public function delete(User $user, Postcomment $postcomment)
    {
		return permission($user, Postcomment::class, 'delete');
    }
}
