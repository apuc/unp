<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class TeamsCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:teams';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Teams from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("teams started...");

		$genders	= \App\Gender::get();
		$api		= config('database.connections.api.database');
		$main		= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.participant")
			->select([
				"{$api}.participant.id",
				"{$api}.participant.name as external_name",
				"{$api}.participant.gender",
				"{$api}.language.name",
				"{$api}.participant.ut",
				"{$api}.participant.del",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.countries")
					->select("{$main}.countries.id")
					->whereColumn("{$main}.countries.external_id", "{$api}.participant.countryFK")
				;

				return "({$query->toSql()}) as country_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$api}.object_participants")
					->select("{$main}.sports.id")
					->leftJoin("{$main}.sports", function ($query) use ($main, $api) {
						$query->whereColumn("{$api}.object_participants.objectFK", "{$main}.sports.external_id");
					})
					->whereColumn("{$api}.object_participants.participantFK", "{$api}.participant.id")
					->where("{$api}.object_participants.object", "?")
					->where("{$api}.object_participants.participant_type", "?")
					->where("{$api}.object_participants.active", "?")
					->where("{$api}.object_participants.del", "?")
					->where("{$main}.sports.has_odds", '?')
				;

				return "({$query->toSql()}) as sport_id";
			}), ['sport', 'team', 'yes', 'no', 1])
			->leftJoin("{$api}.language", function ($query) use ($api) {
				$query
					->whereColumn("{$api}.language.objectFK", "{$api}.participant.id")
					->where("{$api}.language.object", "participant")
					->where("{$api}.language.del", "no")
					->whereExists(function ($query) use ($api) {
						$query
							->select("{$api}.language_type.id")
							->from("{$api}.language_type")
							->whereColumn("{$api}.language_type.id", "{$api}.language.language_typeFK")
							->where("{$api}.language_type.name", config('app.locale'))
							->where("{$api}.language_type.del", "no")
						;
					})
				;
			})
			->whereNotIn("{$api}.participant.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.teams.external_id")
					->from("{$main}.teams")
					->whereNotNull("{$main}.teams.external_id")
				;
			})
			->where("{$api}.participant.del", "no")
			->where("{$api}.participant.type", "team")
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$api}.object_participants")
					->select("{$main}.sports.id")
					->leftJoin("{$main}.sports", function ($query) use ($main, $api) {
						$query->whereColumn("{$api}.object_participants.objectFK", "{$main}.sports.external_id");
					})
					->whereColumn("{$api}.object_participants.participantFK", "{$api}.participant.id")
					->where("{$api}.object_participants.object", "?")
					->where("{$api}.object_participants.participant_type", "?")
					->where("{$api}.object_participants.active", "?")
					->where("{$api}.object_participants.del", "?")
					->where("{$main}.sports.has_odds", '?')
				;

				return "({$query->toSql()}) IS NOT NULL";
			}), ['sport', 'team', 'yes', 'no', 1])
			->get()
		;

		$records->chunk(500)->each(function ($records) use ($genders) {

			$dataset = collect();

			foreach ($records as $record) {
				$data = [
					'name'			=> $record->name ?? $record->external_name,
					'sport_id'		=> $record->sport_id,
					'country_id'	=> $record->country_id,
					'gender'		=> $record->gender,
					'gender_id'		=> call_user_func(function () use ($record, $genders) {
						foreach ($genders as $gender)
							if ($gender->slug == $record->gender)
								return $gender->id;

						return null;
					}),
					'external_id'	=> $record->id,
					'external_name'	=> $record->external_name,
					'updated_at'	=> Carbon::parse($record->ut),
				];

				try {
					$validator = Validator::make($data, [
						'sport_id'		=> 'required',
						'country_id'	=> 'required',
						'gender_id'		=> 'required',
						'name'			=> 'required|min:2|max:255',
						'external_id'	=> 'required|integer',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					$dataset->push($data);

					$this->line("team {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("team {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}

			// вставка
			DB::table('teams')->insert(
				$dataset->map(function ($record) {
					return [
						'created_at'	=> now(),
						'updated_at'	=> now(),
						'sport_id'		=> $record['sport_id'],
						'country_id'	=> $record['country_id'],
						'gender_id'		=> $record['gender_id'],
						'name'			=> $record['name'],
						'external_id'	=> $record['external_id'],
					];
				})->toArray()
			);
		});

		$this->info("all teams completed");
	}
}
