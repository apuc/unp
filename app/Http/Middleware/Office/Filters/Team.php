<?php

namespace App\Http\Middleware\Office\Filters;

use Closure;
use Illuminate\Support\Facades\View;
use App\Gender;
use App\Sport;
use App\Country;

class Team
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
			'name'			=> $request->f_name ?? null,
			'sport'	=> [
				'id'		=> $request->f_sport_id ?? null,
				'record'	=> !empty($request->f_sport_id) ? Sport::find($request->f_sport_id) : null,
			],
			'country'	=> [
				'id'		=> $request->f_country_id ?? null,
				'record'	=> !empty($request->f_country_id) ? Country::find($request->f_country_id) : null,
			],
			'gender'	=> [
				'id'		=> $request->f_gender_id ?? null,
				'record'	=> !empty($request->f_gender_id) ? Gender::find($request->f_gender_id) : null,
			],
			'external_id'	=> $request->f_external_id ?? null,
		]);

		return $next($request);
	}
}
