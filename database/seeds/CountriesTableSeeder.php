<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CountriesTableSeeder extends Seeder
{
	const TABLE_NAME = 'countries';

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
				'flag'			=> $row->flag ?? null,

				'is_enabled'	=> $row->is_enabled,

				'external_id'	=> $row->external_id ?? null,
				'external_name'	=> $row->external_name ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
