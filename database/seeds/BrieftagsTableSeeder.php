<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BrieftagsTableSeeder extends Seeder
{
	const TABLE_NAME = 'brieftags';

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

				'brief_id'		=> $row->brief_id,
				'tag_id'		=> $row->tag_id,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
