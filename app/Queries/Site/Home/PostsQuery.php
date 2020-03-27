<?php

namespace App\Queries\Site\Home;

use Carbon\Carbon;
use App\Queries\Query;

class PostsQuery extends Query
{
	public function run()
	{
		return \App\Post::query()
			->select('posts.*')
			->with([
				'user',
				'sport',
			])
			->withCount([
				'postcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->whereHas('poststatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
			->where('posted_at', '<=', Carbon::now()->toDateTimeString())
			->sortBy('posted_at', 'desc')
			->take(2)
			->get();
	}
}
