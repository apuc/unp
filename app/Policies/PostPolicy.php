<?php

namespace App\Policies;

use \App\User;
use \App\Post;

use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Post::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Post::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Post::class, 'create');
    }

    public function read(User $user, Post $post)
    {
		return permission($user, Post::class, 'read');
    }

    public function update(User $user, Post $post)
    {
		return permission($user, Post::class, 'update');
    }

    public function delete(User $user, Post $post)
    {
		return permission($user, Post::class, 'delete');
    }
}
