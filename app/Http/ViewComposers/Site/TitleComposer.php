<?php

namespace App\Http\ViewComposers\Site;

use Illuminate\View\View;
use Crumb;

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
		$view->with('title', Crumb::caption());
	}
}