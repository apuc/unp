<?php

namespace App\Policies;

use \App\User;
use \App\Issue;

use Illuminate\Auth\Access\HandlesAuthorization;

class IssuePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Issue::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Issue::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Issue::class, 'create');
    }

    public function read(User $user, Issue $issue)
    {
		return permission($user, Issue::class, 'read');
    }

    public function update(User $user, Issue $issue)
    {
		return permission($user, Issue::class, 'update');
    }

    public function delete(User $user, Issue $issue)
    {
		return permission($user, Issue::class, 'delete');
    }
}
