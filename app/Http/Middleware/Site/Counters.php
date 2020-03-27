<?php

namespace App\Http\Middleware\Site;

use Closure;
use Illuminate\Support\Facades\View;
use Facades\App\Queries\Middleware\CountersQuery;

class Counters
{
	public function handle($request, Closure $next)
	{
		// Получаем список счетчиков проекта из кеша и шарим во вьюхах
		View::share('counters',	CountersQuery::get());

		return $next($request);
	}
}
