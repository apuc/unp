<?php

namespace App\Policies;

use \App\User;
use \App\Answer;

use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Answer::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Answer::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Answer::class, 'create');
    }

    public function read(User $user, Answer $answer)
    {
		return permission($user, Answer::class, 'read');
    }

    public function update(User $user, Answer $answer)
    {
		return permission($user, Answer::class, 'update');
    }

    public function delete(User $user, Answer $answer)
    {
		return permission($user, Answer::class, 'delete');
    }
}
