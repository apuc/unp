<?php

namespace App\Http\Controllers\Account;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Account\Personal\UpdateRequest;

class PersonalController extends Controller
{
	/**
	 *
	 *
	 */

	public function index(UpdateRequest $request)
	{
		if ($request->isMethod('post')) {
			$user = Auth::user();
			$user->name		= $request->name;
			$user->email	= $request->email;
			$user->login	= $request->login;
			$user->about	= $request->about;
			$user->phone	= $request->phone;
			$user->save();

			return redirect()->route('account.dashboard.index');
		}

		return view($this->view);
	}
}
