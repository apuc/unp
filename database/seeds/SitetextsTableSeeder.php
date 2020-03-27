<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class SitetextsTableSeeder extends Seeder
{
	const TABLE_NAME = 'sitetexts';

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

				'sitesection_id'	=> $row->sitesection_id,

				'slug'				=> $row->slug,
				'name'				=> $row->name,

				'title'				=> $row->title ?? null,
				'picture'			=> $row->picture ?? null,
				'announce'			=> $row->announce ?? null,

				'content'			=> $row->content,

				'is_enabled'		=> $row->is_enabled,

				'position'			=> $row->position,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
