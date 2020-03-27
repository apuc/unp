<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TournamenttypesTableSeeder extends Seeder
{
	const TABLE_NAME = 'tournamenttypes';

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

				'sport_id'		=> $row->sport_id,

				'name'			=> $row->name,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
