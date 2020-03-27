<?php

namespace App\Policies;

use \App\User;
use \App\Issuetype;

use Illuminate\Auth\Access\HandlesAuthorization;

class IssuetypePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Issuetype::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Issuetype::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Issuetype::class, 'create');
    }

    public function read(User $user, Issuetype $issuetype)
    {
		return permission($user, Issuetype::class, 'read');
    }

    public function update(User $user, Issuetype $issuetype)
    {
		return permission($user, Issuetype::class, 'update');
    }

    public function delete(User $user, Issuetype $issuetype)
    {
		return permission($user, Issuetype::class, 'delete');
    }
}
