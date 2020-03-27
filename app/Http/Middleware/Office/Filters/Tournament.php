<?php

namespace App\Http\Middleware\Office\Filters;

use Closure;
use Illuminate\Support\Facades\View;
use App\Gender;
use App\Sport;
use App\Tournamenttype;

class Tournament
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
			'id'			=> $request->f_id ?? null,
			'name'			=> $request->f_name ?? null,
			'sport'	=> [
				'id'		=> $request->f_sport_id ?? null,
				'record'	=> !empty($request->f_sport_id) ? Sport::find($request->f_sport_id) : null,
			],
			'gender'	=> [
				'id'		=> $request->f_gender_id ?? null,
				'record'	=> !empty($request->f_gender_id) ? Gender::find($request->f_gender_id) : null,
			],
			'tournamenttype'	=> [
				'id'		=> $request->f_tournamenttype_id ?? null,
				'record'	=> !empty($request->f_tournamenttype_id) ? Tournamenttype::find($request->f_tournamenttype_id) : null,
			],
			'external_id'	=> $request->f_external_id ?? null,
			'position'		=> $request->f_position ?? null,
			'is_top'		=> $request->f_is_top ?? null,
		]);

		return $next($request);
	}
}
