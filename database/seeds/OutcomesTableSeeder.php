<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Http\Handlers\SeedHandler as Seed;

class OutcomesTableSeeder extends Seeder
{
	const TABLE_NAME = 'outcomes';

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
					'id'				=> $row->id,
					'created_at'		=> $row->created_at ?? Carbon::now(),
					'updated_at'		=> $row->updated_at ?? Carbon::now(),

					'match_id'			=> $row->match_id,
					'outcometype_id'	=> $row->outcometype_id,
					'outcomesubtype_id'	=> $row->outcomesubtype_id,
					'outcomescope_id'	=> $row->outcomescope_id,
					'team_id'			=> $row->team_id ?? null,

					'external_id'		=> $row->external_id ?? null,
				];

			insert(self::TABLE_NAME, $records);
		}
	}
}
