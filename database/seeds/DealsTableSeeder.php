<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class DealsTableSeeder extends Seeder
{
	const TABLE_NAME = 'deals';

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

				'dealtype_id'		=> $row->dealtype_id,
				'bookmaker_id'		=> $row->bookmaker_id,

				'name'				=> $row->name,

				'url'				=> $row->url,

				'cover'				=> $row->cover ?? null,
				'description'		=> $row->description,

				'started_at'		=> $row->started_at ?? null,
				'finished_at'		=> $row->finished_at,

				'seo_title'			=> $row->seo_title ?? null,
				'seo_keywords'		=> $row->seo_keywords ?? null,
				'seo_description'	=> $row->seo_description ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
