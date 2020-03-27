<?php

namespace App\Observers;

use App\Social;
use Facades\App\Queries\Middleware\SocialsQuery;

class SocialObserver
{
	public function saved(Social $social)
	{
		SocialsQuery::put();
	}

	public function deleted(Social $social)
	{
		SocialsQuery::put();
	}
}