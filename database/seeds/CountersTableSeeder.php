<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CountersTableSeeder extends Seeder
{
	const TABLE_NAME = 'counters';

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

				'name'			=> $row->name,

				'code_head'		=> $row->code_head,
				'code_top'		=> $row->code_top,
				'code_footer'	=> $row->code_footer,
				'code_script'	=> $row->code_script,

				'is_enabled'	=> $row->is_enabled,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
