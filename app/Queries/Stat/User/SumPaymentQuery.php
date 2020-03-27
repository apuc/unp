<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет суммы платежей пользователя
 *
 */
class SumPaymentQuery extends Query
{
	public function run()
	{
		return DB::table('payments')
			->selectRaw("SUM(`payments`.`amount`) as `sum`")
			->where('payments.user_id', $this->value('id'))
			->first()
			->sum;
	}
}
