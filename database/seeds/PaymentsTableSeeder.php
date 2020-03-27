<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PaymentsTableSeeder extends Seeder
{
	const TABLE_NAME = 'payments';

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

				'user_id'		=> $row->user_id,
				'name'			=> $row->amount,
				'paid_at'		=> $row->paid_at,
				'purpose'		=> $row->purpose ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
