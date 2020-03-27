<?php

namespace App\Http\Middleware\Site;

use Closure;
use Illuminate\Support\Facades\View;
use Facades\App\Queries\Middleware\MenuQuery;

class Menu
{
	public function handle($request, Closure $next)
	{                              
		// Получаем список счетчиков проекта из кеша и шарим во вьюхах
		View::share('menusections',	MenuQuery::get());

		return $next($request);
	}
}
