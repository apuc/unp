<?php

namespace App\Policies;

use \App\User;
use \App\Bannercampaign;

use Illuminate\Auth\Access\HandlesAuthorization;

class BannercampaignPolicy
{
    use HandlesAuthorization;

	public function before(User $user, $ability)
	{
		if ($user->is_admin)
			return true;
	}

    public function sidebar(User $user)
    {
		return permission($user, Bannercampaign::class, 'sidebar');
    }

    public function index(User $user)
    {
		return permission($user, Bannercampaign::class, 'read');
    }

    public function create(User $user)
    {
		return permission($user, Bannercampaign::class, 'create');
    }

    public function read(User $user, Bannercampaign $bannercampaign)
    {
		return permission($user, Bannercampaign::class, 'read');
    }

    public function update(User $user, Bannercampaign $bannercampaign)
    {
		return permission($user, Bannercampaign::class, 'update');
    }

    public function delete(User $user, Bannercampaign $bannercampaign)
    {
		return permission($user, Bannercampaign::class, 'delete');
    }
}
