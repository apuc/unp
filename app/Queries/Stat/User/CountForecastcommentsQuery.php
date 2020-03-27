<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

class CountForecastcommentsQuery extends Query
{
	public function run()
	{
		return DB::table("forecastcomments")
			->selectRaw("COUNT(forecastcomments.id) as comments_count")
			->whereExists(function ($query) {
				$query
					->select("commentstatuses.id")
					->from("commentstatuses")
					->whereColumn("forecastcomments.commentstatus_id", "commentstatuses.id")
					->where("commentstatuses.slug", '<>', "declined");
			})
			->where("forecastcomments.user_id", $this->value('id'))
			->first()
			->comments_count;
	}
}
