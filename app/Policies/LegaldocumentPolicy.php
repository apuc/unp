<?php

namespace App\Policies;

use \App\User;
use \App\Legaldocument;

use Illuminate\Auth\Access\HandlesAuthorization;

class LegaldocumentPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Legaldocument::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Legaldocument::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Legaldocument::class, 'create');
    }

    public function read(User $user, Legaldocument $legaldocument)
    {
		return permission($user, Legaldocument::class, 'read');
    }

    public function update(User $user, Legaldocument $legaldocument)
    {
		return permission($user, Legaldocument::class, 'update');
    }

    public function delete(User $user, Legaldocument $legaldocument)
    {
		return permission($user, Legaldocument::class, 'delete');
    }
}
