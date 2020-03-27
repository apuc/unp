<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BannerpostsTableSeeder extends Seeder
{
	const TABLE_NAME = 'bannerposts';

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

				'banner_id'			=> $row->banner_id,
				'sitesection_id'	=> $row->sitesection_id ?? null,
				'bannerplace_id'	=> $row->bannerplace_id,

				'margin'			=> $row->margin ?? null,

				'started_at'		=> $row->started_at ?? null,
				'finished_at'		=> $row->finished_at ?? null,

				'view_limit'		=> $row->view_limit ?? null,
				'view_amount'		=> $row->view_amount,
				'click_limit'		=> $row->click_limit ?? null,
				'click_amount'		=> $row->click_amount,

				'is_enabled'		=> $row->is_enabled,
				'is_debug'			=> $row->is_debug,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
