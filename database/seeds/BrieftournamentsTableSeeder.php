<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BrieftournamentsTableSeeder extends Seeder
{
	const TABLE_NAME = 'brieftournaments';

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
				'id'				=> $row->id,
				'created_at'		=> $row->created_at ?? Carbon::now(),
				'updated_at'		=> $row->updated_at ?? Carbon::now(),

				'brief_id'			=> $row->brief_id,
				'tournament_id'		=> $row->tournament_id,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
