<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

/**
 * Подсчет количества принятых статей пользователя
 * TODO: реализовать фильтрацию "только принятые"
 *
 */
class CountPostsQuery extends Query
{
	public function run()
	{
		return DB::table('posts')
			->selectRaw("COUNT(*) AS `posts_count`")
			->where('posts.user_id', $this->value('id'))
			->first()
			->posts_count;		
	}
}
