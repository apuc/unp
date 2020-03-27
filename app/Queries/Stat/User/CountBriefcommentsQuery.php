<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

class CountBriefcommentsQuery extends Query
{
	public function run()
	{
		return DB::table("briefcomments")
			->selectRaw("COUNT(briefcomments.id) as comments_count")
			->whereExists(function ($query) {
				$query
					->select("commentstatuses.id")
					->from("commentstatuses")
					->whereColumn("briefcomments.commentstatus_id", "commentstatuses.id")
					->where("commentstatuses.slug", '<>', "declined");
			})
			->where("briefcomments.user_id", $this->value('id'))
			->first()
			->comments_count;
	}
}
