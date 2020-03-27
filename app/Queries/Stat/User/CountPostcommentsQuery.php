<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

class CountPostcommentsQuery extends Query
{
	public function run()
	{
		return DB::table("postcomments")
			->selectRaw("COUNT(postcomments.id) as comments_count")
			->whereExists(function ($query) {
				$query
					->select("commentstatuses.id")
					->from("commentstatuses")
					->whereColumn("postcomments.commentstatus_id", "commentstatuses.id")
					->where("commentstatuses.slug", '<>', "declined");
			})
			->where("postcomments.user_id", $this->value('id'))
			->first()
			->comments_count;
	}
}
