<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Artisan;

class RegularCommand extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:regular';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Regular Bunch of Data from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		Artisan::call('import:tournaments');
		Artisan::call('import:seasons');
		Artisan::call('import:stages');
		Artisan::call('import:matches');
		Artisan::call('import:teams');
		Artisan::call('import:participants');
		Artisan::call('import:outcomes');
		Artisan::call('import:offers');
	}
}
