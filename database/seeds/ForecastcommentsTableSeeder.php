<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ForecastcommentsTableSeeder extends Seeder
{
	const TABLE_NAME = 'forecastcomments';

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

				'forecast_id'		=> $row->forecast_id,
				'user_id'			=> $row->user_id,
				'commentstatus_id'	=> $row->commentstatus_id,

				'posted_at'			=> $row->posted_at,

				'message'			=> $row->message,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
