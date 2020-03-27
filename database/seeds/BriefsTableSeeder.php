<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BriefsTableSeeder extends Seeder
{
	const TABLE_NAME = 'briefs';

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

				'user_id'			=> $row->user_id,
				'sport_id'			=> $row->sport_id,
				'briefstatus_id'	=> $row->briefstatus_id,

				'name'				=> $row->name,

				'picture'			=> $row->picture ?? null,
				'picture_author'	=> $row->picture_author ?? null,

				'announce'			=> $row->announce ?? null,
				'content'			=> $row->content,

				'posted_at'			=> $row->posted_at,

				'seo_title'			=> $row->seo_title ?? null,
				'seo_keywords'		=> $row->seo_keywords ?? null,
				'seo_description'	=> $row->seo_description ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
