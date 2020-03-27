<?php

namespace App\Http\Middleware\Site;

use Closure;
use Illuminate\Support\Facades\View;
use Facades\App\Queries\Middleware\TextsQuery;

class Texts
{
	public function handle($request, Closure $next)
	{
		// Получаем тексты из кеша и шарим во вьюхах
		View::share('layout', TextsQuery::get());

		return $next($request);
	}
}
