<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class MenuitemsTableSeeder extends Seeder
{
	const TABLE_NAME = 'menuitems';

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

				'menusection_id'	=> $row->menusection_id,

				'name'				=> $row->name,
				'url'				=> $row->url,
				'is_enabled'		=> $row->is_enabled,
				'position'			=> $row->position,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
