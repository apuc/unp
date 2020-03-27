<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class OutcomesubtypesCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:outcomesubtypes';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Outcome Subtypes from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("outcomesubtypes started...");

		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.outcome_subtype")
			->select([
				"{$api}.outcome_subtype.id",
				"{$api}.outcome_subtype.name",
				"{$api}.outcome_subtype.description",
				"{$api}.outcome_subtype.ut",
				"{$api}.outcome_subtype.del",
			])
			->whereNotIn("{$api}.outcome_subtype.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.outcomesubtypes.external_id")
					->from("{$main}.outcomesubtypes")
					->whereNotNull("{$main}.outcomesubtypes.external_id")
				;
			})
			->where("{$api}.outcome_subtype.del", "no")
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
					$query = DB::table('outcomesubtypes')
						->selectRaw('COALESCE(MAX(outcomesubtypes.position), 0) AS position')
						->first()
					;

					return $query->position + 1;
				}),
			];

			try {
				$validator = Validator::make($data, [
					'name'			=> 'required|min:2|max:255|unique:outcomesubtypes,name',
					'slug'			=> 'required|min:2|max:255|unique:outcomesubtypes,slug',
					'position'		=> 'required|integer|min:1|unique:outcomesubtypes,position',
					'external_id'	=> 'required|integer',
				]);

				if ($validator->fails())
					throw new \Exception(implode('; ', $validator->errors()->all()));

				$outcomesubtype = new \App\Outcomesubtype;
				$outcomesubtype->name					= $data['name'];
				$outcomesubtype->slug					= $data['slug'];
				$outcomesubtype->description			= $data['description'];
				$outcomesubtype->position				= $data['position'];
				$outcomesubtype->external_id			= $data['external_id'];
				$outcomesubtype->external_name			= $data['name'];
				$outcomesubtype->external_description	= $data['description'];
				$outcomesubtype->is_enabled				= 1;
				$outcomesubtype->save();

				$this->line("outcomesubtype {$data['external_id']} imported");
			}
			catch (\Exception $e) {
				$this->error("outcomesubtype {$data['external_id']} failed with error: " . $e->getMessage());
			}
		}

		$this->info("all outcomesubtypes completed");
	}
}
