<?php

namespace App\Console\Calc;

use Illuminate\Console\Command;

class UsersCommand extends Command
{

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'calc:users';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Calculate Statistics of Users';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("calculaction statistics of users started...");

		$users = \App\User::get();

		foreach ($users as $user) {
			$user->updatePostsStat();
			$user->updateBriefsStat();
			$user->updateCommentsStat();
			$user->updateForecastsStat();

			$user->save();
    
			$this->info("user" 
				. " id: {$user->id}" 
				. " login: {$user->login}" 
				. " balance: {$user->balance}" 
				. " forecasts: {$user->stat_forecasts}" 
				. " wins: {$user->stat_wins}" 
				. " losses: {$user->stat_losses}" 
				. " draws: {$user->stat_draws}"
				. " luck: {$user->stat_luck}%"
			);
		}

		$this->info("calculation statistics of users completed");
	}
}
