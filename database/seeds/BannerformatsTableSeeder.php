<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BannerformatsTableSeeder extends Seeder
{
	const TABLE_NAME = 'bannerformats';

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

				'width'			=> $row->width,
				'height'		=> $row->height,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
