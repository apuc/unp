<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ForecastsTableSeeder extends Seeder
{
	const TABLE_NAME = 'forecasts';

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
				'outcome_id'		=> $row->outcome_id,
				'bookmaker_id'		=> $row->bookmaker_id,
				'match_id'			=> $row->match_id,
				'user_id'			=> $row->user_id,
				'forecaststatus_id'	=> $row->forecaststatus_id,

				'outcometype_id'	=> $row->outcometype_id,
				'outcomescope_id'	=> $row->outcomescope_id,
				'outcomesubtype_id'	=> $row->outcomesubtype_id,
				'team_id'			=> $row->team_id ?? null,

				'rate'				=> $row->rate,
				'bet'				=> $row->bet,
				'posted_at'			=> $row->posted_at,
				'description'		=> $row->description,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
