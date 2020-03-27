<?php

namespace App\Http\Middleware\Office\Filters;

use Closure;
use Illuminate\Support\Facades\View;
use App\Sport;
use App\Poststatus;
use App\User;

class Post
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

			'posted_at'	=> $request->f_posted_at ? [
				!empty($request->f_posted_at[0]) ? \Carbon\Carbon::parse($request->f_posted_at[0]) : null,
				!empty($request->f_posted_at[1]) ? \Carbon\Carbon::parse($request->f_posted_at[1]) : null,
			] : [null, null],

			'poststatus'		=> [
				'id'			=> $request->f_poststatus_id ?? null,
				'record'		=> !empty($request->f_poststatus_id) ? Poststatus::find($request->f_poststatus_id) : null,
			],

			'sport'	=> [
				'id'			=> $request->f_sport_id ?? null,
				'record'		=> !empty($request->f_sport_id) ? Sport::find($request->f_sport_id) : null,
			],

			'user'	=> [
				'id'			=> $request->f_user_id ?? null,
				'record'		=> !empty($request->f_user_id) ? User::find($request->f_user_id) : null,
			],
		]);

		return $next($request);
	}
}
