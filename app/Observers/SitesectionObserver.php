<?php

namespace App\Observers;

use App\Sitesection;
use Facades\App\Queries\Middleware\TextsQuery;

class SitesectionObserver
{
	public function saved(Sitesection $sitesection)
	{
		TextsQuery::put();
	}

	public function deleted(Sitesection $sitesection)
	{
		TextsQuery::put();
	}
}