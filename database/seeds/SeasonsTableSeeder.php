<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SeasonsTableSeeder extends Seeder
{
	const TABLE_NAME = 'seasons';

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

				'tournament_id'	=> $row->tournament_id,

				'name'			=> $row->name,
				'external_id'	=> $row->external_id ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
