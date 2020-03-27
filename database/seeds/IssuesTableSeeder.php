<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class IssuesTableSeeder extends Seeder
{
	const TABLE_NAME = 'issues';

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
				'issuetype_id'	=> $row->issuetype_id,
				'issuestatus_id'=> $row->issuestatus_id,

				'author'		=> $row->author ?? null,
				'email'			=> $row->email ?? null,

				'message'		=> $row->message,

				'posted_at'		=> $row->posted_at,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
