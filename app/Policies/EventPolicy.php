<?php

namespace App\Policies;

use \App\User;
use \App\Event;

use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Event::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Event::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Event::class, 'create');
    }

    public function read(User $user, Event $event)
    {
		return permission($user, Event::class, 'read');
    }

    public function update(User $user, Event $event)
    {
		return permission($user, Event::class, 'update');
    }

    public function delete(User $user, Event $event)
    {
		return permission($user, Event::class, 'delete');
    }
}
