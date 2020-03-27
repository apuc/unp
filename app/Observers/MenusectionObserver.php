<?php

namespace App\Observers;

use App\Menusection;
use Facades\App\Queries\Middleware\MenuQuery;

class MenusectionObserver
{
	public function saved(Menusection $menusection)
	{
		MenuQuery::put();
	}

	public function deleted(Menusection $menusection)
	{
		MenuQuery::put();
	}
}