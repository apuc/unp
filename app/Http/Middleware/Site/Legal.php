<?php

namespace App\Http\Middleware\Site;

use Closure;
use Illuminate\Support\Facades\View;

class Legal
{
	public function handle($request, Closure $next)
	{
		$legaldocuments = \App\Legaldocument::query()
			->selectRaw('legaldocuments.*, (SELECT MAX(issued_at) FROM legaleditions WHERE legaldocuments.id = legaleditions.legaldocument_id) issued_at')
			->orderBy('position', 'asc')
			->get()
			->reject(function ($document) {
				return $document->issued_at === null;
			})
		;

		// Шарим во вьюхах
		View::share(compact('legaldocuments'));

		return $next($request);
	}
}
