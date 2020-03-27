<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class ActionsTableSeeder extends Seeder
{
	const TABLE_NAME = 'actions';

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

				'actiongroup_id'=> $row->actiongroup_id,

				'slug'			=> $row->slug,
				'name'			=> $row->name,

				'description'	=> $row->description ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
