<?php

namespace App\Http\Middleware\Site;

use Closure;
use Illuminate\Support\Facades\View;
use Facades\App\Queries\Middleware\SocialsQuery;

class Socials
{
	public function handle($request, Closure $next)
	{
		// Получаем список социалок из кеша и шарим во вьюхах
		View::share('socials', SocialsQuery::get());

		return $next($request);
	}
}
