<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CustomparamsTableSeeder extends Seeder
{
	const TABLE_NAME = 'customparams';

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

				'customgroup_id'=> $row->customgroup_id,
				'customtype_id'	=> $row->customtype_id,

				'slug'			=> $row->slug,
				'name'			=> $row->name,

				'value_string'	=> $row->value_string ?? null,
				'value_integer'	=> $row->value_integer ?? null,
				'value_text'	=> $row->value_text ?? null,
				'value_float'	=> $row->value_float ?? null,
				'value_boolean'	=> $row->value_boolean ?? null,
				'value_date'	=> $row->value_date ?? null,
				'value_datetime'=> $row->value_datetime ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
