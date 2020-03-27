<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class OutcomescopesCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:outcomescopes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Outcome Scopes from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("outcomescopes started...");

		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.outcome_scope")
			->select([
				"{$api}.outcome_scope.id",
				"{$api}.outcome_scope.name",
				"{$api}.outcome_scope.description",
				"{$api}.outcome_scope.ut",
				"{$api}.outcome_scope.del",
			])
			->whereNotIn("{$api}.outcome_scope.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.outcomescopes.external_id")
					->from("{$main}.outcomescopes")
					->whereNotNull("{$main}.outcomescopes.external_id")
				;
			})
			->where("{$api}.outcome_scope.del", "no")
			->get()
		;

		foreach ($records as $record) {
			$data = [
				'name'			=> $record->name,
				'slug'			=> str_slug($record->name),
				'description'	=> $record->description,
				'external_id'	=> $record->id,
				'updated_at'	=> Carbon::parse($record->ut),
				'position'		=> call_user_func(function () {
					$query = DB::table('outcomescopes')
						->selectRaw('COALESCE(MAX(outcomescopes.position), 0) AS position')
						->first()
					;

					return $query->position + 1;
				}),
			];

			try {
				$validator = Validator::make($data, [
					'name'			=> 'required|min:2|max:255|unique:outcomescopes,name',
					'slug'			=> 'required|min:2|max:255|unique:outcomescopes,slug',
					'position'		=> 'required|integer|min:1|unique:outcomescopes,position',
					'external_id'	=> 'required|integer',
				]);

				if ($validator->fails())
					throw new \Exception(implode('; ', $validator->errors()->all()));

				$outcomescope = new \App\Outcomescope;
				$outcomescope->name					= $data['name'];
				$outcomescope->slug					= $data['slug'];
				$outcomescope->description			= $data['description'];
				$outcomescope->position				= $data['position'];
				$outcomescope->external_id			= $data['external_id'];
				$outcomescope->external_name		= $data['name'];
				$outcomescope->external_description	= $data['description'];
				$outcomescope->is_enabled			= 1;
				$outcomescope->save();

				$this->line("outcomescope {$data['external_id']} imported");
			}
			catch (\Exception $e) {
				$this->error("outcomescope {$data['external_id']} failed with error: " . $e->getMessage());
			}
		}

		$this->info("all outcomescopes completed");
	}
}
