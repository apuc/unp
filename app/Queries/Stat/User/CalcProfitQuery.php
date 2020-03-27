<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет процента прибыли пользователя
 *
 */
class CalcProfitQuery extends Query
{
	public function run()
	{
		// Если сумма ставок нулевая, то и прибыли нет
		if ($this->value('bet') == 0)
			return 0;
		
		return ($this->value('win') - $this->value('lose')) * 100 / $this->value('start');
	}
}
