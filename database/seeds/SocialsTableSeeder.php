<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SocialsTableSeeder extends Seeder
{
	const TABLE_NAME = 'socials';

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
				'site'			=> $row->site,
				'community'		=> $row->community ?? null,
				'icon'			=> $row->icon,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
