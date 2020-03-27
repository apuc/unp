<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookmakersTableSeeder extends Seeder
{
	const TABLE_NAME = 'bookmakers';

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

				'slug'				=> $row->slug,
				'name'				=> $row->name,
				'external_id'		=> $row->external_id ?? null,

				'logo'				=> $row->logo ?? null,
				'cover'				=> $row->cover ?? null,

				'bonus'				=> $row->bonus ?? null,

				'announce'			=> $row->announce ?? null,
				'description'		=> $row->description ?? null,

				'site'				=> $row->site ?? null,
				'phone'				=> $row->phone ?? null,
				'email'				=> $row->email ?? null,
				'address'			=> $row->address ?? null,

				'position'			=> $row->position,

				'is_enabled'		=> $row->is_enabled ?? null,

				'seo_title'			=> $row->seo_title ?? null,
				'seo_keywords'		=> $row->seo_keywords ?? null,
				'seo_description'	=> $row->seo_description ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
