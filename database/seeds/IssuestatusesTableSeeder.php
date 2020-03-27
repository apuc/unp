<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class IssuestatusesTableSeeder extends Seeder
{
	const TABLE_NAME = 'issuestatuses';

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

				'slug'			=> $row->slug ?? str_slug($row->name),
				'name'			=> $row->name,

				'color_bg'		=> $row->color_bg ?? null,
				'color_fg'		=> $row->color_fg ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
