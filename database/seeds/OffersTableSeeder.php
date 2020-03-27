<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Http\Handlers\SeedHandler as Seed;

class OffersTableSeeder extends Seeder
{
	const TABLE_NAME = 'offers';

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */

	public function run()
	{
		DB::table(self::TABLE_NAME)->delete();

		$dateset = new Seed(self::TABLE_NAME);

		foreach ($dateset as $rows) {
			$records = [];
			foreach ($rows as $row)
				$records[] = [
					'id'			=> $row->id,
					'created_at'	=> $row->created_at ?? Carbon::now(),
					'updated_at'	=> $row->updated_at ?? Carbon::now(),

					'bookmaker_id'	=> $row->bookmaker_id,
					'outcome_id'	=> $row->outcome_id,
					'odds_current'	=> $row->odds_current,
					'odds_old'		=> $row->odds_old,
					'coupon'		=> $row->coupon ?? null,
					'external_id'	=> $row->external_id ?? null,
					'has_offers'	=> $row->has_offers ?? null,
				];

			insert(self::TABLE_NAME, $records);
		}
	}
}
