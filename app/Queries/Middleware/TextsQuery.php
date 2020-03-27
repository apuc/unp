<?php

namespace App\Queries\Middleware;

use App\Queries\Query;

class TextsQuery extends Query
{
	public function run()
	{
		return \App\Sitesection::query()
			->selectBySlug('all')
			->first();
	}
}
