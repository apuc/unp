<?php

namespace App\Http\Middleware\Office\Filters;

use Closure;
use Illuminate\Support\Facades\View;
use App\Role;

class User
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
			'f_login'	=> $request->f_login ?? null,
			'f_name'	=> $request->f_name ?? null,
			'f_phone'	=> $request->f_phone ?? null,
			'f_email'	=> $request->f_email ?? null,
			'f_born_at'	=> $request->has('f_born_at') && !empty($request->f_born_at) ? \Carbon\Carbon::parse($request->f_born_at) : null,
			'f_role'	=> [
				'id'		=> $request->f_role_id ?? null,
				'record'	=> !empty($request->f_role_id) ? Role::find($request->f_role_id) : null,
			],
		]);

		return $next($request);
	}
}
