<?php

namespace App\Queries\Site\Home;

use Carbon\Carbon;
use App\Queries\Query;

class BriefsQuery extends Query
{
	public function run()
	{
		return \App\Brief::query()
			->select('briefs.*')
			->with([
				'user',
				'sport',
			])
			->withCount([
				'briefcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->whereHas('briefstatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
			->where('posted_at', '<=', Carbon::now()->toDateTimeString())
			->sortBy('posted_at', 'desc')
			->take(14)
			->get();
	}
}
