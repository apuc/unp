<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HelpsectionsTableSeeder extends Seeder
{
	const TABLE_NAME = 'helpsections';

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
				'id'							=> $row->id,
				'created_at'					=> $row->created_at ?? Carbon::now(),
				'updated_at'					=> $row->updated_at ?? Carbon::now(),

				'slug'							=> $row->slug,
				'name'							=> $row->name,
				'icon'							=> $row->icon ?? null,

				'announce'						=> $row->announce ?? null,
				'text_header'					=> $row->text_header ?? null,
				'text_footer'					=> $row->text_footer ?? null,

				'is_enabled'					=> $row->is_enabled,

				'seo_title'						=> $row->seo_title ?? null,
				'seo_keywords'					=> $row->seo_keywords ?? null,
				'seo_description'				=> $row->seo_description ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
