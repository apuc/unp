<?php

namespace App\Console\Warmup;

use Illuminate\Console\Command;
use App\Traits\LoggableCommand;

use Facades\App\Queries\Middleware\MenuQuery;
use Facades\App\Queries\Middleware\TextsQuery;
use Facades\App\Queries\Middleware\SocialsQuery;
use Facades\App\Queries\Middleware\CountersQuery;

class MiddlewareCommand extends Command
{
    use LoggableCommand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */                                       

	protected $signature = 'warmup:middleware'
								. ' {--load : Load queries from database to cache}'
								. ' {--clean : Clean cache}';


	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Warmup Middleware';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("warmup middleware started...");

		if ($this->options()['clean'])
			$this->clean();
		else 
			$this->load();	

		$this->info("warmup middleware completed");
	}

	/**
	 * Очистка кеша
	 *
	 */
	                                  
	private function clean()
	{
		MenuQuery::clean();
		TextsQuery::clean();
		SocialsQuery::clean();
		CountersQuery::clean();

		$this->info("cache was cleaned");
	}

	/**
	 * Загрузка значений в кеш
	 *
	 */

	private function load()
	{
		MenuQuery::put();
		TextsQuery::put();
		SocialsQuery::put();
		CountersQuery::put();

		$this->info("cache was loaded");
	}
}
