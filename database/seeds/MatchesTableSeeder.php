<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Http\Handlers\SeedHandler as Seed;

class MatchesTableSeeder extends Seeder
{
	const TABLE_NAME = 'matches';

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

					'matchstatus_id'	=> $row->matchstatus_id,
					'stage_id'			=> $row->stage_id ?? null,

					'name'				=> $row->name,
					'external_id'		=> $row->external_id ?? null,
					'started_at'		=> $row->started_at,

					'odds1_current'		=> $row->odds1_current ?? null,
					'odds1_old'			=> $row->odds1_old ?? null,
					'oddsx_current'		=> $row->oddsx_current ?? null,
					'oddsx_old'			=> $row->oddsx_old ?? null,
					'odds2_current'		=> $row->odds2_current ?? null,
					'odds2_old'			=> $row->odds2_old ?? null,

					'bookmaker1_id'		=> $row->bookmaker1_id ?? null,
					'bookmakerx_id'		=> $row->bookmakerx_id ?? null,
					'bookmaker2_id'		=> $row->bookmaker2_id ?? null,
				];

			insert(self::TABLE_NAME, $records);
		}
	}
}
