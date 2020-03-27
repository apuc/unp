<?php

namespace App\Policies;

use \App\User;
use \App\Briefstatus;

use Illuminate\Auth\Access\HandlesAuthorization;

class BriefstatusPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Briefstatus::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Briefstatus::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Briefstatus::class, 'create');
    }

    public function read(User $user, Briefstatus $briefstatus)
    {
		return permission($user, Briefstatus::class, 'read');
    }

    public function update(User $user, Briefstatus $briefstatus)
    {
		return permission($user, Briefstatus::class, 'update');
    }

    public function delete(User $user, Briefstatus $briefstatus)
    {
		return permission($user, Briefstatus::class, 'delete');
    }
}
