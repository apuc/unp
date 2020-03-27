<?php

namespace App\Queries\Middleware;

use App\Queries\Query;

class CountersQuery extends Query
{
	public function run()
	{
		return \App\Counter::query()
			->where('is_enabled', true)
			->get();
	}
}
