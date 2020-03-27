<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class BookmakersCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:bookmakers';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Bookmakers from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$this->info("bookmakers started...");

		$records = DB::connection('api')
			->table("{$api}.odds_provider")
			->select([
				"{$api}.odds_provider.id",
				"{$api}.odds_provider.name",
				"{$api}.odds_provider.url",
				"{$api}.odds_provider.ut",
				"{$api}.odds_provider.del",
			])
			->whereNotIn("{$api}.odds_provider.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.bookmakers.external_id")
					->from("{$main}.bookmakers")
					->whereNotNull("{$main}.bookmakers.external_id")
				;
			})
			->where("{$api}.odds_provider.del", "no")
			->where("{$api}.odds_provider.active", "yes")
			->where("{$api}.odds_provider.bookmaker", "yes")
			->get()
		;

		foreach ($records as $record) {
			$data = [
				'name'			=> $record->name,
				'slug'			=> str_slug($record->name),
				'site'			=> $record->url,
				'external_id'	=> $record->id,
				'updated_at'	=> Carbon::parse($record->ut),
				'position'		=> call_user_func(function () {
					$query = DB::table('bookmakers')
						->selectRaw('COALESCE(MAX(bookmakers.position), 0) AS position')
						->first()
					;

					return $query->position + 1;
				}),
			];

			try {
				$validator = Validator::make($data, [
					'name'			=> 'required|min:2|max:255|unique:bookmakers,name',
					'slug'			=> 'required|min:2|max:255|unique:bookmakers,slug',
					'site'			=> 'nullable|min:2|max:255|unique:bookmakers,site',
					'position'		=> 'required|integer|min:1|unique:bookmakers,position',
					'external_id'	=> 'required|integer',
				]);

				if ($validator->fails())
					throw new \Exception(implode('; ', $validator->errors()->all()));

				$bookmaker = new \App\Bookmaker;
				$bookmaker->name		= $data['name'];
				$bookmaker->slug		= $data['slug'];
				$bookmaker->site		= $data['site'];
				$bookmaker->position	= $data['position'];
				$bookmaker->external_id	= $data['external_id'];
				$bookmaker->is_enabled	= 0;
				$bookmaker->save();

				$this->line("bookmaker {$data['external_id']} imported");
			}
			catch (\Exception $e) {
				$this->error("bookmaker {$data['external_id']} failed with error: " . $e->getMessage());
			}
		}

		$this->info("all bookmakers completed");
	}
}
