<?php

namespace App\Queries\Site\Home;

use App\Queries\Query;

class UsersQuery extends Query
{
	public function run()
	{
		return \App\User::query()
			->select('users.*')
			->where('users.stat_forecasts', '>', 0)
			->orderBy('users.stat_profit', 'desc')
			->take(7)
			->get();
	}
}
