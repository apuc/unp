<?php

namespace App\Console\Warmup\Site;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Validator;
use App\Traits\LoggableCommand;
use Illuminate\Support\Facades\Cache;

use Facades\App\Queries\Site\Match\MatchesQuery;
use Facades\App\Queries\Site\Match\OffersQuery;

class MatchesYesterdayCommand extends Command
{
    use LoggableCommand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature = 'warmup:matches.yesterday'
								. ' {--load : Load site matches page from database to cache}'
								. ' {--clean : Clean cache}';


	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Warmup Site Matches Yesterday';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("warmup matches.yesterday started...");

		if ($this->options()['clean'])
			$this->clean();
		else
			$this->load();

		$this->info("warmup matches.yesterday completed");
	}

	/**
	 * Очистка кеша
	 *
	 */

	private function clean()
	{
		$this->info("cache was cleaned");
	}

	/**
	 * Загрузка значений в кеш
	 *
	 */

	private function load()
	{
		$sports = MatchesQuery::where('date', now()->subDay(1)->format('Y-m-d'))->expire(24*60*60)->put();

		foreach ($sports as $sport)
			foreach ($sport['tournaments'] as $tournament)
				foreach ($tournament['matches'] as $match_id => $match)
					OffersQuery::where('match_id', $match_id)->expire(24*60*60)->put();

		$this->info("cache was loaded");
	}
}
