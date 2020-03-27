<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет баланса пользователя
 *
 */
class CalcBalanceQuery extends Query
{
	public function run()
	{
		return $this->value('start') + $this->value('payments') + $this->value('win') - $this->value('lose') - $this->value('confirmed');
	}
}
