<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class BookmakerpicturesTableSeeder extends Seeder
{
	const TABLE_NAME = 'bookmakerpictures';

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

				'bookmakertext_id'	=> $row->bookmakertext_id,
				'name'				=> $row->name ?? null,
				'picture'			=> $row->picture,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
