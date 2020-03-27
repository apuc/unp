<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	/**
	 * The Artisan commands provided by your application.
	 *
	 * @var array
	 */

	protected $commands = [
		\Siteset\Dump\Console\DumpCommand::class,

		\App\Console\Import\SportsCommand::class,
		\App\Console\Import\CountriesCommand::class,
		\App\Console\Import\TournamentsCommand::class,
		\App\Console\Import\SeasonsCommand::class,
		\App\Console\Import\StagesCommand::class,
		\App\Console\Import\MatchesCommand::class,
		\App\Console\Import\TeamsCommand::class,
		\App\Console\Import\ParticipantsCommand::class,
		\App\Console\Import\BookmakersCommand::class,
		\App\Console\Import\OutcometypesCommand::class,
		\App\Console\Import\OutcomescopesCommand::class,
		\App\Console\Import\OutcomesubtypesCommand::class,
		\App\Console\Import\OutcomesCommand::class,
		\App\Console\Import\OffersCommand::class,

		\App\Console\Import\RegularCommand::class,

		\App\Console\Calc\UsersCommand::class,

		\App\Console\Warmup\MiddlewareCommand::class,
		\App\Console\Warmup\Site\HomeCommand::class,
		\App\Console\Warmup\Site\MatchesPastCommand::class,
		\App\Console\Warmup\Site\MatchesFutureCommand::class,
		\App\Console\Warmup\Site\MatchesTodayCommand::class,
		\App\Console\Warmup\Site\MatchesYesterdayCommand::class,
	];

	/**
	 * Define the application's command schedule.
	 *
	 * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
	 * @return void
	 */

	protected function schedule(Schedule $schedule)
	{
		$schedule->command('import:regular')
			->everyFifteenMinutes();

		$schedule->command('warmup:site.home')
			->everyFiveMinutes();

		$schedule->command('warmup:matches.today')
			->everyFiveMinutes();

		$schedule->command('warmup:matches.past')
			->daily();

		$schedule->command('warmup:matches.future')
			->daily();

		for ($h = 0; $h < 2; $h++)
			for ($i = 0; $i < 12; $i++) {
				$m = $i * 5;
				$schedule->command('warmup:matches.yesterday')->dailyAt(
					'0' . $h . ':' . ( $m < 10 ? '0' . $m : $m)
				);
			}

		$schedule->command('warmup:matches.yesterday')->dailyAt('02:00');

		$schedule->command('queue:work --queue=default --once')
			->everyMinute();
	}

	/**
	 * Register the commands for the application.
	 *
	 * @return void
	 */

	protected function commands()
	{
		$this->load(__DIR__.'/Commands');

		require base_path('routes/console.php');
	}
}
