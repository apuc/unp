<?php

namespace App\Policies;

use \App\User;
use \App\Offer;

use Illuminate\Auth\Access\HandlesAuthorization;

class OfferPolicy
{
	use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

	public function sidebar(User $user)
	{
		return permission($user, Offer::class, 'sidebar');
	}

	public function index(User $user)
	{
		return permission($user, Offer::class, 'read');
	}

	public function create(User $user)
	{
		return permission($user, Offer::class, 'create');
	}

	public function read(User $user, Offer $offer)
	{
		return permission($user, Offer::class, 'read');
	}

	public function update(User $user, Offer $offer)
	{
		return permission($user, Offer::class, 'update');
	}

	public function delete(User $user, Offer $offer)
	{
		return permission($user, Offer::class, 'delete');
	}
}
