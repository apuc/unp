<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NoticebansTableSeeder extends Seeder
{
	const TABLE_NAME = 'noticebans';

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
				'id'			=> $row->id,
				'created_at'	=> $row->created_at ?? Carbon::now(),
				'updated_at'	=> $row->updated_at ?? Carbon::now(),

				'noticetype_id'	=> $row->noticetype_id,
				'action_id'		=> $row->action_id,
				'user_id'		=> $row->user_id,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
