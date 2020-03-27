<?php

namespace App\Http\Controllers\Account;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Account\Password\UpdateRequest;

class PasswordController extends Controller
{
	/**
	 *
	 *
	 */

	public function index(UpdateRequest $request)
	{
		if ($request->isMethod('post')) {
			$user = Auth::user();
			$user->password = bcrypt($request->password);
			$user->save();

			return redirect()->route('account.dashboard.index');
		}

		return view($this->view);
	}
}
