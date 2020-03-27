<?php

namespace App\Policies;

use \App\User;
use \App\Issuestatus;

use Illuminate\Auth\Access\HandlesAuthorization;

class IssuestatusPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Issuestatus::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Issuestatus::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Issuestatus::class, 'create');
    }

    public function read(User $user, Issuestatus $issuestatus)
    {
		return permission($user, Issuestatus::class, 'read');
    }

    public function update(User $user, Issuestatus $issuestatus)
    {
		return permission($user, Issuestatus::class, 'update');
    }

    public function delete(User $user, Issuestatus $issuestatus)
    {
		return permission($user, Issuestatus::class, 'delete');
    }
}
