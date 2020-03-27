<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class OutcometypesCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:outcometypes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Outcome Types from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("outcometypes started...");

		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.outcome_type")
			->select([
				"{$api}.outcome_type.id",
				"{$api}.outcome_type.name",
				"{$api}.outcome_type.description",
				"{$api}.outcome_type.ut",
				"{$api}.outcome_type.del",
			])
			->whereNotIn("{$api}.outcome_type.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.outcometypes.external_id")
					->from("{$main}.outcometypes")
					->whereNotNull("{$main}.outcometypes.external_id")
				;
			})
			->where("{$api}.outcome_type.del", "no")
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
					$query = DB::table('outcometypes')
						->selectRaw('COALESCE(MAX(outcometypes.position), 0) AS position')
						->first()
					;

					return $query->position + 1;
				}),
			];

			try {
				$validator = Validator::make($data, [
					'name'			=> 'required|min:2|max:255|unique:outcometypes,name',
					'slug'			=> 'required|min:2|max:255|unique:outcometypes,slug',
					'position'		=> 'required|integer|min:1|unique:outcometypes,position',
					'external_id'	=> 'required|integer',
				]);

				if ($validator->fails())
					throw new \Exception(implode('; ', $validator->errors()->all()));

				$outcometype = new \App\Outcometype;
				$outcometype->name					= $data['name'];
				$outcometype->slug					= $data['slug'];
				$outcometype->description			= $data['description'];
				$outcometype->position				= $data['position'];
				$outcometype->external_id			= $data['external_id'];
				$outcometype->external_name			= $data['name'];
				$outcometype->external_description	= $data['description'];
				$outcometype->is_enabled			= 1;
				$outcometype->save();

				$this->line("outcometype {$data['external_id']} imported");
			}
			catch (\Exception $e) {
				$this->error("outcometype {$data['external_id']} failed with error: " . $e->getMessage());
			}
		}

		$this->info("all outcometypes completed");
	}
}
