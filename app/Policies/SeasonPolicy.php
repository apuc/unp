<?php

namespace App\Policies;

use \App\User;
use \App\Season;

use Illuminate\Auth\Access\HandlesAuthorization;

class SeasonPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Season::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Season::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Season::class, 'create');
    }

    public function read(User $user, Season $season)
    {
		return permission($user, Season::class, 'read');
    }

    public function update(User $user, Season $season)
    {
		return permission($user, Season::class, 'update');
    }

    public function delete(User $user, Season $season)
    {
		return permission($user, Season::class, 'delete');
    }
}
