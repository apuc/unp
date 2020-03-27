<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers as BaseAuthenticatesUsers;
use Illuminate\Support\Facades\Hash;

trait AuthenticatesUsers
{
	use BaseAuthenticatesUsers;

	/**
	 * Attempt to log the user into the application.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return bool
	 */

	protected function attemptLogin(Request $request)
	{
		// получаем по мылу
		if (null === ($user = \App\User::where('email', $request->get($this->username()))->first()))
			// получаем по логину
			if (null === ($user = \App\User::where('login', $request->get($this->username()))->first()))
				// получаем по телефону
				$user = \App\User::where('phone', \Morph::phone($request->get($this->username())))->first();


		if (!is_null($user) && Hash::check($request->password, $user->password)) {
			$this->guard()->login($user, (bool)$request->remember);

			return true;
		}

		return false;
	}
}
