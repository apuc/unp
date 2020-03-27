<?php

namespace App\Policies;

use \App\User;
use \App\Legaledition;

use Illuminate\Auth\Access\HandlesAuthorization;

class LegaleditionPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Legaledition::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Legaledition::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Legaledition::class, 'create');
    }

    public function read(User $user, Legaledition $legaledition)
    {
		return permission($user, Legaledition::class, 'read');
    }

    public function update(User $user, Legaledition $legaledition)
    {
		return permission($user, Legaledition::class, 'update');
    }

    public function delete(User $user, Legaledition $legaledition)
    {
		return permission($user, Legaledition::class, 'delete');
    }
}
