<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет суммы выигравших ставок пользователя
 *
 */
class SumWinQuery extends Query
{
	public function run()
	{
		return DB::table('forecasts')
			->selectRaw("SUM(forecasts.rate * forecasts.bet - forecasts.bet) as `sum`")
			->where('forecasts.user_id', $this->value('id'))
			->whereExists(function ($query) {
				$query
					->select('forecaststatuses.id')
					->from('forecaststatuses')
					->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
					->where('forecaststatuses.slug', 'win');
			})
			->first()
			->sum;
	}
}
