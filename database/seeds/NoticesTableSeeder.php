<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NoticesTableSeeder extends Seeder
{
	const TABLE_NAME = 'notices';

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run()
	{
		DB::table(self::TABLE_NAME)->delete();

		foreach (seed(self::TABLE_NAME) as $row)
			$records[] = [
				'id'					=> $row->id,
				'created_at'			=> $row->created_at ?? Carbon::now(),
				'updated_at'			=> $row->updated_at ?? Carbon::now(),

				'event_id'				=> $row->event_id,
				'noticetype_id'			=> $row->noticetype_id,
				'noticestatus_id'		=> $row->noticestatus_id,
				'user_id'				=> $row->user_id,

				'message'				=> $row->message,

				'posted_at'				=> $row->posted_at,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
