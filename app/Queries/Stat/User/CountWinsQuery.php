<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет количества выигравших прогнозов пользователя
 *
 */
class CountWinsQuery extends Query
{
	public function run()
	{
		return DB::table('forecasts')
			->selectRaw("COUNT(`forecasts`.`id`) as `forecasts_count`")
			->where('forecasts.user_id', $this->value('id'))
			->whereExists(function ($query) {
				$query
					->select('forecaststatuses.id')
					->from('forecaststatuses')
					->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
					->where('forecaststatuses.slug', 'win');
			})
			->first()
			->forecasts_count;
	}
}
