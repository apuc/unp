<?php

namespace App\Console\Warmup\Site;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Validator;
use App\Traits\LoggableCommand;
use Illuminate\Support\Facades\Cache;

use Facades\App\Queries\Site\Home\TextsQuery;
use Facades\App\Queries\Site\Home\PostsQuery;
use Facades\App\Queries\Site\Home\BriefsQuery;
use Facades\App\Queries\Site\Home\ForecastsQuery;
use Facades\App\Queries\Site\Home\UsersQuery;
use Facades\App\Queries\Site\Home\BookmakersQuery;
use Facades\App\Queries\Site\Home\DealsQuery;
use Facades\App\Queries\Site\Home\MatchesQuery;
use Facades\App\Queries\Site\Home\TournamentsQuery;
use Facades\App\Queries\Site\Home\BenefitsQuery;

class HomeCommand extends Command
{
    use LoggableCommand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */                                       

	protected $signature = 'warmup:site.home'
								. ' {--load : Load site home page from database to cache}'
								. ' {--clean : Clean cache}';


	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Warmup Site Home';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("warmup site.home started...");

		if ($this->options()['clean'])
			$this->clean();
		else 
			$this->load();	

		$this->info("warmup site.home completed");
	}

	/**
	 * Очистка кеша
	 *
	 */
	                                  
	private function clean()
	{
		TextsQuery::clean();
		PostsQuery::clean();
		BriefsQuery::clean();
		ForecastsQuery::clean();
		UsersQuery::clean();
		BookmakersQuery::clean();
		DealsQuery::clean();
		MatchesQuery::clean();
		TournamentsQuery::clean();
		BenefitsQuery::clean();

		$this->info("cache was cleaned");
	}

	/**
	 * Загрузка значений в кеш
	 *
	 */

	private function load()
	{
		TextsQuery::put();
		PostsQuery::put();
		BriefsQuery::put();
		ForecastsQuery::put();
		UsersQuery::put();
		BookmakersQuery::put();
		DealsQuery::put();
		MatchesQuery::put();
		TournamentsQuery::put();
		BenefitsQuery::put();

		$this->info("cache was loaded");
	}
}
