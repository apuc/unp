<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет процента выигрыша пользователя
 *
 */
class CalcLuckQuery extends Query
{
	public function run()
	{
		$all = $this->value('wins') + $this->value('losses') + $this->value('draws');

		// если нет никаких ставок, то и считать нечего
		if ($all == 0)
			return 0;

		return intval($this->value('wins') * 100 / $all);
	}
}
