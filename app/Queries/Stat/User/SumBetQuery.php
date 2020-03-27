<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет суммы завершенных ставок пользователя
 *
 */
class SumBetQuery extends Query
{
	public function run()
	{
		return DB::table('forecasts')
			->selectRaw("SUM(forecasts.bet) as `sum`")
			->where('forecasts.user_id', $this->value('id'))
			->whereExists(function ($query) {
				$query
					->select('forecaststatuses.id')
					->from('forecaststatuses')
					->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
					->whereIn('forecaststatuses.slug', ['win', 'lose', 'draw']);
			})
			->first()
			->sum;
	}
}
