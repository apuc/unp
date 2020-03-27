<?php

namespace App\Policies;

use \App\User;
use \App\Helpsection;

use Illuminate\Auth\Access\HandlesAuthorization;

class HelpsectionPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Helpsection::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Helpsection::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Helpsection::class, 'create');
    }

    public function read(User $user, Helpsection $helpsection)
    {
		return permission($user, Helpsection::class, 'read');
    }

    public function update(User $user, Helpsection $helpsection)
    {
		return permission($user, Helpsection::class, 'update');
    }

    public function delete(User $user, Helpsection $helpsection)
    {
		return permission($user, Helpsection::class, 'delete');
    }
}
