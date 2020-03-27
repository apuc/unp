<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет средней ставки пользователя
 *
 */
class AverageBetQuery extends Query
{
	public function run()
	{
		return DB::table('forecasts')
			->selectRaw("AVG(`forecasts`.`bet`) as `bet_avg`")
			->where('forecasts.user_id', $this->value('id'))
			->whereExists(function ($query) {
				$query
					->select('forecaststatuses.id')
					->from('forecaststatuses')
					->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
					->whereIn('forecaststatuses.slug', ['win', 'lose', 'draw']);
			})
			->first()
			->bet_avg;
	}
}
