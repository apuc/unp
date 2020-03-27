<?php

namespace App\Policies;

use \App\User;
use \App\Stage;

use Illuminate\Auth\Access\HandlesAuthorization;

class StagePolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Stage::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Stage::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Stage::class, 'create');
    }

    public function read(User $user, Stage $stage)
    {
		return permission($user, Stage::class, 'read');
    }

    public function update(User $user, Stage $stage)
    {
		return permission($user, Stage::class, 'update');
    }

    public function delete(User $user, Stage $stage)
    {
		return permission($user, Stage::class, 'delete');
    }
}
