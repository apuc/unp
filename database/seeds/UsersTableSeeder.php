<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
	const TABLE_NAME = 'users';

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

				'role_id'						=> $row->role_id,

				'name'							=> $row->name ?? null,
				'login'							=> $row->login,

				'email'							=> $row->email,
				'email_verified_at'				=> $row->email_verified_at ?? null,

				'phone'							=> nullable(Morph::phone($row->phone)),
				'phone_verified_at'				=> $row->phone_verified_at ?? null,

				'password'						=> $row->password,
				'remember_token'				=> $row->remember_token ?? null,

				'born_at'						=> $row->born_at ?? null,
				'avatar'						=> $row->avatar ?? null,
				'balance'						=> $row->balance ?? 0,
				'visited_at'					=> $row->visited_at  ?? Carbon::now(),

				'stat_profit'					=> $row->stat_profit ?? 0,
				'stat_roi'						=> $row->stat_roi ?? 0,
				'stat_forecasts'				=> $row->stat_forecasts ?? 0,
				'stat_briefs'					=> $row->stat_briefs ?? 0,
				'stat_posts'					=> $row->stat_posts ?? 0,
				'stat_wins'						=> $row->stat_wins ?? 0,
				'stat_losses'					=> $row->stat_losses ?? 0,
				'stat_draws'					=> $row->stat_draws ?? 0,
				'stat_offer'					=> $row->stat_offer ?? 0,
				'stat_bet'						=> $row->stat_bet ?? 0,
				'stat_luck'						=> $row->stat_luck ?? 0,
				'stat_comments'					=> $row->stat_comments ?? 0,

				'about'							=> $row->about ?? null,
			];

		insert(self::TABLE_NAME, $records ?? []);
	}
}
