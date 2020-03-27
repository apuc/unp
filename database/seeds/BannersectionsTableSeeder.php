<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BannersectionsTableSeeder extends Seeder
{
	const TABLE_NAME = 'bannersections';

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

				'bannersection_id'	=> $row->bannersection_id,
				'bannerplace_id'	=> $row->bannerplace_id,
				'sitesection_id'	=> $row->sitesection_id,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
