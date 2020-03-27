<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SportsTableSeeder extends Seeder
{
	const TABLE_NAME = 'sports';

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

				'slug'			=> $row->slug,
				'name'			=> $row->name,

				'is_enabled'	=> $row->is_enabled,
				'position'		=> $row->position ?? null,
				'has_odds'		=> $row->has_odds ?? null,
				'icon'			=> $row->icon ?? null,

				'external_id'	=> $row->external_id ?? null,
				'external_name'	=> $row->external_name ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
