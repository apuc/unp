<?php

namespace App\Http\ViewComposers\Office;

use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class TitleComposer
{
	/**
	 * Bind data to the view.
	 *
	 * @param  View  $view
	 * @return void
	 */

	public function compose(View $view)
	{
		$view->with('title', trans('page.' . Route::currentRouteName(), $view->getData()['parameters'] ?? []));
	}
}