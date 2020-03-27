<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HelpquestionsTableSeeder extends Seeder
{
	const TABLE_NAME = 'helpquestions';

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
				'id'							=> $row->id,
				'created_at'					=> $row->created_at ?? Carbon::now(),
				'updated_at'					=> $row->updated_at ?? Carbon::now(),

				'helpsection_id'				=> $row->helpsection_id,

				'name'							=> $row->name,
				'answer'						=> $row->answer,

				'is_enabled'					=> $row->is_enabled,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
