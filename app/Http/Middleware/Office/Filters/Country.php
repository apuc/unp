<?php

namespace App\Http\Middleware\Office\Filters;

use Closure;
use Illuminate\Support\Facades\View;

class Country
{
	/**
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */

	public function handle($request, Closure $next)
	{
		View::share([
			'name'				=> $request->f_name ?? null,

			'slug'				=> $request->f_slug ?? null,

			'external_id'		=> $request->f_external_id ?? null,

			'external_name'		=> $request->f_external_name ?? null,

			'is_enabled'		=> $request->f_is_enabled ?? null,
		]);

		return $next($request);
	}
}
