<?php

namespace App\Policies;

use \App\User;
use \App\Payment;

use Illuminate\Auth\Access\HandlesAuthorization;

class PaymentPolicy
{
	use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

	public function sidebar(User $user)
	{
		return permission($user, Payment::class, 'sidebar');
	}

	public function index(User $user)
	{
		return permission($user, Payment::class, 'read');
	}

	public function create(User $user)
	{
		return permission($user, Payment::class, 'create');
	}

	public function read(User $user, Payment $payment)
	{
		return permission($user, Payment::class, 'read');
	}

	public function update(User $user, Payment $payment)
	{
		return permission($user, Payment::class, 'update');
	}

	public function delete(User $user, Payment $payment)
	{
		return permission($user, Payment::class, 'delete');
	}
}
