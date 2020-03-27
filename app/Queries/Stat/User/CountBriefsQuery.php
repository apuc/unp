<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет количества принятых новостей пользователя
 * TODO: реализовать фильтрацию "только принятые"
 *
 */
class CountBriefsQuery extends Query
{
	public function run()
	{
		return DB::table('briefs')
			->selectRaw("COUNT(*) AS `briefs_count`")
			->where('briefs.user_id', $this->value('id'))
			->first()
			->briefs_count;
	}
}
