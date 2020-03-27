<?php

namespace App\Http\Middleware\Office\Filters;

use Closure;
use Illuminate\Support\Facades\View;

class Bookmaker
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

			'site'				=> $request->f_site ?? null,

			'phone'				=> $request->f_phone ?? null,

			'email'				=> $request->f_email ?? null,

			'address'			=> $request->f_address ?? null,

			'bonus'				=> $request->f_bonus ?? null,

			'external_id'		=> $request->f_external_id ?? null,

			'is_enabled'		=> $request->f_is_enabled ?? null,
		]);

		return $next($request);
	}
}
