<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NoticetemplatesTableSeeder extends Seeder
{
	const TABLE_NAME = 'noticetemplates';

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

				'action_id'		=> $row->action_id,
				'noticetype_id'	=> $row->noticetype_id,
				'role_id'		=> $row->role_id,

				'message'		=> $row->message,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
