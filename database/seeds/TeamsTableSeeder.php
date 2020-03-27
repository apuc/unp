<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Http\Handlers\SeedHandler as Seed;

class TeamsTableSeeder extends Seeder
{
	const TABLE_NAME = 'teams';

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run()
	{
		DB::table(self::TABLE_NAME)->delete();

		$dateset = new Seed(self::TABLE_NAME);

		foreach ($dateset as $rows) {
			$records = [];
			foreach ($rows as $row)
				$records[] = [
					'id'			=> $row->id,
					'created_at'	=> $row->created_at ?? Carbon::now(),
					'updated_at'	=> $row->updated_at ?? Carbon::now(),

					'sport_id'		=> $row->sport_id,
					'country_id'	=> $row->country_id,
					'gender_id'		=> $row->gender_id,

					'name'			=> $row->name,
					'external_id'	=> $row->external_id ?? null,
					'logo'			=> $row->logo ?? null,
				];

			insert(self::TABLE_NAME, $records);
		}
	}
}
