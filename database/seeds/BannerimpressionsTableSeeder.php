<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BannerimpressionsTableSeeder extends Seeder
{
	const TABLE_NAME = 'bannerimpressions';

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

				'bannerpost_id'	=> $row->bannerpost_id,
				'user_id'		=> $row->user_id ?? null,

				'impressed_at'	=> $row->impressed_at,

				'ip'			=> $row->ip ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
