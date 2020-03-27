<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class TournamentsTableSeeder extends Seeder
{
	const TABLE_NAME = 'tournaments';

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

				'sport_id'			=> $row->sport_id,
				'gender_id'			=> $row->gender_id,
				'tournamenttype_id'	=> $row->tournamenttype_id ?? null,

				'name'				=> $row->name,
				'external_id'		=> $row->external_id ?? null,
				'is_top'			=> $row->is_top ?? null,
				'logo'				=> $row->logo ?? null,
				'position'			=> $row->position ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
