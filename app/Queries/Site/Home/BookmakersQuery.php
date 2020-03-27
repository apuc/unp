<?php

namespace App\Queries\Site\Home;

use App\Queries\Query;

class BookmakersQuery extends Query
{
	public function run()
	{
		return \App\Bookmaker::query()
			->select('bookmakers.*')
			->sortBy('position')
			->take(9)
			->get();
	}
}
