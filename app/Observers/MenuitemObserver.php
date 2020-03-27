<?php

namespace App\Observers;

use App\Menuitem;
use Facades\App\Queries\Middleware\MenuQuery;

class MenuitemObserver
{
	public function saved(Menuitem $menuitem)
	{
		MenuQuery::put();
	}

	public function deleted(Menuitem $menuitem)
	{
		MenuQuery::put();
	}
}