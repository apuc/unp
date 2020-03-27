<?php

namespace App\Queries\Site\Home;

use App\Queries\Query;

class DealsQuery extends Query
{
	public function run()
	{
		return \App\Deal::query()
			->select('deals.*')
			->with([
				'bookmaker',
			])
			->sortBy('started_at', 'desc')
			->take(3)
			->get();
	}
}
