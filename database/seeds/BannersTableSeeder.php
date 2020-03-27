<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BannersTableSeeder extends Seeder
{
	const TABLE_NAME = 'banners';

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

				'bannerformat_id'	=> $row->bannerformat_id,
				'bannercampaign_id'	=> $row->bannercampaign_id,

				'name'				=> $row->name,
				'picture'			=> $row->picture,
				'link'				=> $row->link,
				'html'				=> $row->html ?? null,
				'alt'				=> $row->alt ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
