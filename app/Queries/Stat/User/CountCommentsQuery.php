<?php

namespace App\Queries\Stat\User;

use App\Queries\Query;
use DB;

class CountCommentsQuery extends Query
{
	public function run()
	{
		$id = $this->value('id');

		$getComments = function ($table) use ($id) {
			return DB::table("{$table}")
				->selectRaw("COUNT(`{$table}`.`id`) as comments_count")
				->whereExists(function ($query) use ($table) {
					$query
						->select("commentstatuses.id")
						->from("commentstatuses")
						->whereColumn("{$table}.commentstatus_id", "commentstatuses.id")
						->where("commentstatuses.slug", '<>', "declined");
				})
				->where("{$table}.user_id", $id)
				->first()
				->comments_count;
		};

		return call_user_func($getComments, 'postcomments') 
			+  call_user_func($getComments, 'briefcomments') 
			+  call_user_func($getComments, 'forecastcomments');
	}
}
