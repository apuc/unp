<?php

namespace App\Policies;

use \App\User;
use \App\Participant;

use Illuminate\Auth\Access\HandlesAuthorization;

class ParticipantPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Participant::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Participant::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Participant::class, 'create');
    }

    public function read(User $user, Participant $participant)
    {
		return permission($user, Participant::class, 'read');
    }

    public function update(User $user, Participant $participant)
    {
		return permission($user, Participant::class, 'update');
    }

    public function delete(User $user, Participant $participant)
    {
		return permission($user, Participant::class, 'delete');
    }
}
