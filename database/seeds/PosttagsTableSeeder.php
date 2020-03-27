<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PosttagsTableSeeder extends Seeder
{
	const TABLE_NAME = 'posttags';

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

				'post_id'		=> $row->post_id,
				'tag_id'		=> $row->tag_id,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
