<?php

namespace App\Policies;

use \App\User;
use \App\Helpquestion;

use Illuminate\Auth\Access\HandlesAuthorization;

class HelpquestionPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Helpquestion::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Helpquestion::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Helpquestion::class, 'create');
    }

    public function read(User $user, Helpquestion $helpquestion)
    {
		return permission($user, Helpquestion::class, 'read');
    }

    public function update(User $user, Helpquestion $helpquestion)
    {
		return permission($user, Helpquestion::class, 'update');
    }

    public function delete(User $user, Helpquestion $helpquestion)
    {
		return permission($user, Helpquestion::class, 'delete');
    }
}
