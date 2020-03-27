<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class MatchesCommand extends Command
{
    use LoggableCommand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:matches'
								. ' {--insert : Insert new entries}'
								. ' {--update : Update records}'
								. ' {--offers : Update offers}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Matches from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("matches started...");

		if (true === $this->options()['insert'])
			$this->insert();

		elseif (true === $this->options()['update'])
			$this->update();

		elseif (true === $this->options()['offers'])
			$this->offers();

		else {
			$this->update();
			$this->insert();
		}

		$this->info("all matches completed");
	}

	/**
	 *
	 *
	 *
	 */

	private function insert()
	{
		$matchstatuses	= \App\Matchstatus::get();
		$api			= config('database.connections.api.database');
		$main			= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.event")
			->select([
				"{$api}.event.id",
				"{$api}.event.name as external_name",

				"{$api}.event.startdate",
				"{$api}.event.status_type",

				"{$api}.language.name",
				"{$api}.event.ut",
				"{$api}.event.del",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.stages")
					->select("{$main}.stages.id")
					->whereColumn("{$main}.stages.external_id", "{$api}.event.tournament_stageFK")
				;

				return "({$query->toSql()}) as stage_id";
			}))
			->leftJoin("{$api}.language", function ($query) use ($api) {
				$query
					->whereColumn("{$api}.language.objectFK", "{$api}.event.id")
					->where("{$api}.language.object", "event")
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
			->whereNotIn("{$api}.event.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.matches.external_id")
					->from("{$main}.matches")
					->whereNotNull("{$main}.matches.external_id")
				;
			})
			->where("{$api}.event.del", "no")
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.stages")
					->select("{$main}.stages.id")
					->whereColumn("{$main}.stages.external_id", "{$api}.event.tournament_stageFK")
				;

				return "({$query->toSql()}) IS NOT NULL";
			}))
			->get()
		;

		$records->chunk(500)->each(function ($records) use ($matchstatuses) {

			$dataset = collect();

			foreach ($records as $record) {
				$data = [
					'name'				=> $record->name ?? $record->external_name,
					'matchstatus_id'	=> call_user_func(function () use ($matchstatuses, $record) {
						foreach ($matchstatuses as $matchstatus)
							if ($matchstatus->slug == $record->status_type)
								return $matchstatus->id;

						return null;
					}),
					'stage_id'			=> $record->stage_id,
					'started_at'		=> Carbon::parse($record->startdate)->addHours(2),
					'external_id'		=> $record->id,
					'external_name'		=> $record->external_name,
					'updated_at'		=> Carbon::parse($record->ut),
				];

				try {
					$validator = Validator::make($data, [
						'matchstatus_id'	=> 'required',
						'stage_id'			=> 'required',
						'name' 				=> 'required|min:2|max:255',
						'external_id'		=> 'required|integer',
						'started_at' 		=> 'required|date',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					$dataset->push($data);

					$this->line("match {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("match {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}

			// вставка
			DB::table('matches')->insert(
				$dataset->map(function ($record) {
					return [
						'created_at'		=> now(),
						'updated_at'		=> now(),
						'matchstatus_id'	=> $record['matchstatus_id'],
						'stage_id'			=> $record['stage_id'],
						'name'				=> $record['name'],
						'external_id'		=> $record['external_id'],
						'started_at'		=> $record['started_at'],

						'odds1_current'		=> null,
						'odds1_old'			=> null,
						'bookmaker1_id'		=> null,

						'oddsx_current'		=> null,
						'oddsx_old'			=> null,
						'bookmakerx_id'		=> null,

						'odds2_current'		=> null,
						'odds2_old'			=> null,
						'bookmaker2_id'		=> null,
					];
				})->toArray()
			);
		});
	}

	/**
	 *
	 *
	 *
	 */

	private function update()
	{
		$matchstatuses	= \App\Matchstatus::get();
		$api			= config('database.connections.api.database');
		$main			= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.event")
			->select([
				"{$api}.event.id",
				"{$api}.event.startdate",
				"{$api}.event.status_type",
				"{$api}.event.ut",
			])
			->whereIn("{$api}.event.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.matches.external_id")
					->from("{$main}.matches")
					->whereNotNull("{$main}.matches.external_id")
				;
			})
			->whereRaw(call_user_func(function () use ($main, $api) {
				$first = DB::table("{$main}.matches")
					->select("{$main}.matches.updated_at")
					->whereColumn("{$main}.matches.external_id", "{$api}.event.id")
					->toSql()
				;

				$second = DB::table("{$main}.matches")
					->select("{$main}.matchstatuses.slug")
					->leftJoin("{$main}.matchstatuses", "{$main}.matches.matchstatus_id", "=", "{$main}.matchstatuses.id")
					->whereColumn("{$main}.matches.external_id", "{$api}.event.id")
					->toSql()
				;

				return "( {$api}.event.ut > ({$first}) OR {$api}.event.status_type <> ({$second}) )";
			}))
			->get()
		;

		$records->chunk(500)->each(function ($records) use ($matchstatuses) {
			foreach ($records as $record) {
				$data = [
					'matchstatus_id'	=> call_user_func(function () use ($matchstatuses, $record) {
						foreach ($matchstatuses as $matchstatus)
							if ($matchstatus->slug == $record->status_type)
								return $matchstatus->id;

						return null;
					}),
					'started_at'		=> Carbon::parse($record->startdate)->addHours(2),
					'external_id'		=> $record->id,
				];

				try {
					$validator = Validator::make($data, [
						'matchstatus_id'	=> 'required',
						'started_at' 		=> 'required|date',
						'external_id'		=> 'required|integer',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					// обновление
					DB::table('matches')
						->where('external_id', $data['external_id'])
						->update([
							'updated_at'		=> now(),
							'matchstatus_id'	=> $data['matchstatus_id'],
							'started_at'		=> $data['started_at'],
						]);

					$this->line("match {$data['external_id']} updated");
				}
				catch (\Exception $e) {
					$this->error("match {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}
		});
	}

	/**
	 *
	 *
	 */

	private function offers()
	{
		/*
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.event")
			->select([
				"{$api}.event.id",
				"{$api}.event.startdate",
				"{$api}.event.status_type",
				"{$api}.event.ut",
			])
			->whereIn("{$api}.event.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.matches.external_id")
					->from("{$main}.matches")
					->whereNotNull("{$main}.matches.external_id")
					->whereExists(function ($query) use ($main) {
						$query
							->select("{$main}.matchstatuses.id")
							->from("{$main}.matchstatuses")
							->whereColumn("{$main}.matches.matchstatus_id", "{$main}.matchstatuses.id")
							->whereNotIn("{$main}.matchstatuses.slug", ["finished", "deleted", "cancelled"])
						;
					})
				;
			})
			->get()
		;

		$records->chunk(500)->each(function ($records) {
			$dataset = collect();
			foreach ($records as $record) {
				// получаем исходы
				$outcomes = $this->getOutcomes($record->id);

				$data = [
					'odds1_current'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == 1)
								return $outcome->odds_current;

						return null;
					}),
					'odds1_old'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == 1)
								return $outcome->odds_old;

						return null;
					}),
					'bookmaker1_id'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == 1)
								return $outcome->bookmaker_id;

						return null;
					}),
					'oddsx_current'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == null)
								return $outcome->odds_current;

						return null;
					}),
					'oddsx_old'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == null)
								return $outcome->odds_old;

						return null;
					}),
					'bookmakerx_id'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == null)
								return $outcome->bookmaker_id;

						return null;
					}),
					'odds2_current'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == 2)
								return $outcome->odds_current;

						return null;
					}),
					'odds2_old'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == 2)
								return $outcome->odds_old;

						return null;
					}),
					'bookmaker2_id'		=> call_user_func(function () use ($outcomes) {
						foreach ($outcomes as $outcome)
							if ($outcome->number == 2)
								return $outcome->bookmaker_id;

						return null;
					}),
					'external_id'		=> $record->id,
				];

				if (
						!is_null($data['odds1_current']) || !is_null($data['odds1_old']) || !is_null($data['bookmaker1_id'])
					||	!is_null($data['oddsx_current']) || !is_null($data['oddsx_old']) || !is_null($data['bookmakerx_id'])
					||	!is_null($data['odds2_current']) || !is_null($data['odds2_old']) || !is_null($data['bookmaker2_id'])
				)
					$dataset->push($data);

				$this->line("offers for match {$data['external_id']} updated");
			}

			if ($dataset->count())
				DB::statement(""
					. "UPDATE"
						. " `matches`"
					. " SET"
						// первый выбранный коэффициент
						. " `odds1_current` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['odds1_current']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['odds1_current']}'";
							})->implode(" ")
						. " END,"

						// первый старый коэффициент
						. " `odds1_old` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['odds1_old']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['odds1_old']}'";
							})->implode(" ")
						. " END,"

						// первый букмекер
						. " `bookmaker1_id` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['bookmaker1_id']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['bookmaker1_id']}'";
							})->implode(" ")
						. " END,"

						///////////////////////

						// X выбранный коэффициент
						. " `oddsx_current` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['oddsx_current']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['oddsx_current']}'";
							})->implode(" ")
						. " END,"

						// X старый коэффициент
						. " `oddsx_old` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['oddsx_old']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['oddsx_old']}'";
							})->implode(" ")
						. " END,"

						// X букмекер
						. " `bookmakerx_id` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['bookmakerx_id']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['bookmakerx_id']}'";
							})->implode(" ")
						. " END,"

						///////////////////////

						// второй выбранный коэффициент
						. " `odds2_current` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['odds2_current']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['odds2_current']}'";
							})->implode(" ")
						. " END,"

						// второй старый коэффициент
						. " `odds2_old` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['odds2_old']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['odds2_old']}'";
							})->implode(" ")
						. " END,"

						// второй букмекер
						. " `bookmaker2_id` = CASE `external_id`"
							. $dataset->map(function ($record) {
								if (is_null($record['bookmaker2_id']))
									return " WHEN {$record['external_id']} THEN NULL";

								return " WHEN {$record['external_id']} THEN '{$record['bookmaker2_id']}'";
							})->implode(" ")
						. " END"

					. " WHERE"
						. " `external_id` IN ("
							. $dataset->map(function ($record) {
								return $record['external_id'];
							})->implode(",")
						. ")"
				);
		});
		* */
	}

	/**
	 *
	 *
	 */

	/*
	private function getOutcomes($match_id)
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		return DB::connection('api')
			->table("{$api}.outcome")
			// odds_current
			->selectRaw(call_user_func(function () use ($api, $main) {
				$query = DB::table("{$api}.bettingoffer")
					->select("{$api}.bettingoffer.odds")
					->whereColumn("{$api}.bettingoffer.outcomeFK", "{$api}.outcome.id")
					->where("{$api}.bettingoffer.active", "?")
					->where("{$api}.bettingoffer.del", "?")
					->whereIn("{$api}.bettingoffer.odds_providerFK", function ($query) use ($main) {
						$query
							->from("{$main}.bookmakers")
							->select("{$main}.bookmakers.external_id")
							->where("{$main}.bookmakers.is_enabled", "?")
						;
					})
					->orderBy("{$api}.bettingoffer.odds", "DESC")
					->skip(0)
					->take(1)
				;
				return "({$query->toSql()}) as odds_current";
			}), ['yes', 'no', 1])

			// odds_old
			->selectRaw(call_user_func(function () use ($api, $main) {
				$query = DB::table("{$api}.bettingoffer")
					->select("{$api}.bettingoffer.odds_old")
					->whereColumn("{$api}.bettingoffer.outcomeFK", "{$api}.outcome.id")
					->where("{$api}.bettingoffer.active", "?")
					->where("{$api}.bettingoffer.del", "?")
					->whereIn("{$api}.bettingoffer.odds_providerFK", function ($query) use ($main) {
						$query
							->from("{$main}.bookmakers")
							->select("{$main}.bookmakers.external_id")
							->where("{$main}.bookmakers.is_enabled", "?")
						;
					})
					->orderBy("{$api}.bettingoffer.odds_old", "DESC")
					->skip(0)
					->take(1)
				;

				return "({$query->toSql()}) as odds_old";
			}), ['yes', 'no', 1])

			// bookmaker_id
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.bookmakers")
					->select("{$main}.bookmakers.id")
					->where("{$main}.bookmakers.external_id", function ($query) use ($api, $main) {
						$query
							->from("{$api}.bettingoffer")
							->select("{$api}.bettingoffer.odds_providerFK")
							->whereColumn("{$api}.bettingoffer.outcomeFK", "{$api}.outcome.id")
							->where("{$api}.bettingoffer.active", "?")
							->where("{$api}.bettingoffer.del", "?")
							->whereIn("{$api}.bettingoffer.odds_providerFK", function ($query) use ($main) {
								$query
									->from("{$main}.bookmakers")
									->select("{$main}.bookmakers.external_id")
									->where("{$main}.bookmakers.is_enabled", "?")
								;
							})
							->orderBy("{$api}.bettingoffer.odds", "DESC")
							->skip(0)
							->take(1)
						;
					})
				;

				return "({$query->toSql()}) as bookmaker_id";
			}), ['yes', 'no', 1])

			// number
			->selectRaw(call_user_func(function () use ($api) {
				$query = DB::table("{$api}.event_participants")
					->select("{$api}.event_participants.number")

					->whereColumn("{$api}.event_participants.participantFK", "{$api}.outcome.iparam")
					->whereColumn("{$api}.event_participants.eventFK", "{$api}.outcome.objectFK")
					->where("{$api}.event_participants.del", "?")
				;

				return "({$query->toSql()}) as number";
			}), ['no'])

			->where("{$api}.outcome.object", "event")
			->where("{$api}.outcome.objectFK", $match_id)
			->whereExists(function ($query) use ($api) {
				$query
					->select("{$api}.outcome_type.id")
					->from("{$api}.outcome_type")
					->whereColumn("{$api}.outcome_type.id", "{$api}.outcome.outcome_typeFK")
					->where("{$api}.outcome_type.name", '1x2')
					->where("{$api}.outcome_type.del", "no")
				;
			})
			->whereExists(function ($query) use ($api) {
				$query
					->select("{$api}.outcome_scope.id")
					->from("{$api}.outcome_scope")
					->whereColumn("{$api}.outcome_scope.id", "{$api}.outcome.outcome_scopeFK")
					->where("{$api}.outcome_scope.name", 'ord')
					->where("{$api}.outcome_scope.del", "no")
				;
			})
			->get()
		;
	}
	*/
}
