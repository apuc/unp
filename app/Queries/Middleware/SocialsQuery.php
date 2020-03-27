<?php

namespace App\Queries\Middleware;

use App\Queries\Query;

class SocialsQuery extends Query
{
	public function run()
	{
		return \App\Social::query()
			->whereNotNull('community')
			->orderBy('name')
			->get();
	}
}
