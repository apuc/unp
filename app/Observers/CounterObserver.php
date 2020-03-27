<?php

namespace App\Observers;

use App\Counter;
use Facades\App\Queries\Middleware\CountersQuery;

class CounterObserver
{
	public function saved(Counter $counter)
	{
		CountersQuery::put();
    }

	public function deleted(Counter $counter)
	{
		CountersQuery::put();
	}
}