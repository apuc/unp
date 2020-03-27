<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет количества всех прогнозов пользователя
 * TODO: реализовать фильтрацию "только подтвержденные и завершенные"
 *
 */
class CountForecastsQuery extends Query
{
	public function run()
	{
		return DB::table('forecasts')
			->selectRaw("COUNT(*) AS `forecasts_count`")
			->where('forecasts.user_id', $this->value('id'))
            ->first()
            ->forecasts_count;
	}
}
