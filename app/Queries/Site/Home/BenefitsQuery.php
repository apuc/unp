<?php

namespace App\Queries\Site\Home;

use App\Queries\Query;

class BenefitsQuery extends Query
{
	public function run()
	{
		return \App\Benefit::query()
			->select('benefits.*')
			->sortBy('position')
			->take(4)
			->get();
	}
}
