<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет среднего коэффициента ставок пользователя
 *
 */
class AverageRateQuery extends Query
{
	public function run()
	{
		return DB::table('forecasts')
			->selectRaw("AVG(`forecasts`.`rate`) as `odds_avg`")
			->where('forecasts.user_id', $this->value('id'))
			->whereExists(function ($query) {
				$query
					->select('forecaststatuses.id')
					->from('forecaststatuses')
					->whereColumn('forecasts.forecaststatus_id', 'forecaststatuses.id')
					->whereIn('forecaststatuses.slug', ['win', 'lose', 'draw']);
			})
			->first()
			->odds_avg;
	}
}
