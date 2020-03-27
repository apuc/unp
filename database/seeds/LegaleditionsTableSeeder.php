<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LegaleditionsTableSeeder extends Seeder
{
	const TABLE_NAME = 'legaleditions';

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

				'legaldocument_id'	=> $row->legaldocument_id,
				'issued_at'			=> $row->issued_at,
				'content'			=> $row->content,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
