<?php

namespace App\Http\Controllers\Account;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class NoticeController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		return view($this->view);
	}
}
