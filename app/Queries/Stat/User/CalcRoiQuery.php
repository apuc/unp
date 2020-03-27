<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет процента возврата инвестиций (roi) пользователя
 *
 */
class CalcRoiQuery extends Query
{
	public function run()
	{
		// Если сумма ставок нулевая, то и инвестиций нет, считать нечего
		if ($this->value('bet') == 0)
			return 0;
		
		return $this->value('win') / $this->value('bet') * 100;
	}
}
