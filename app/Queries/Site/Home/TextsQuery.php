<?php

namespace App\Queries\Site\Home;

use App\Queries\Query;

class TextsQuery extends Query
{
	public function run()
	{
		return \App\Sitesection::query()
			->selectBySlug('home')
			->first();
	}
}
