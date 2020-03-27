<?php

namespace App\Http\Controllers\Account;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class SocialController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		$usersocials = \App\Usersocial::query()
			->select('usersocials.*')
			->with([
				'user',
				'social',
			])
			->where('usersocials.user_id', \Auth::user()->id)
			->get()
		;

		return view($this->view, compact(
			'usersocials'
		));
	}

	/**
	 *
	 *
	 */

	public function destroy($id)
	{
		$usersocial = \App\Usersocial::query()
			->select('usersocials.*')
			->where('usersocials.user_id', \Auth::user()->id)
			->findOrFail($id)
		;

		$usersocial->delete();
	}
}
