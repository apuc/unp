<?php

namespace App\Policies;

use \App\User;
use \App\Tag;

use Illuminate\Auth\Access\HandlesAuthorization;

class TagPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Tag::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Tag::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Tag::class, 'create');
    }

    public function read(User $user, Tag $tag)
    {
		return permission($user, Tag::class, 'read');
    }

    public function update(User $user, Tag $tag)
    {
		return permission($user, Tag::class, 'update');
    }

    public function delete(User $user, Tag $tag)
    {
		return permission($user, Tag::class, 'delete');
    }
}
