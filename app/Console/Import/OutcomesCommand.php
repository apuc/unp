<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class OutcomesCommand extends Command
{
    use LoggableCommand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:outcomes'
								. ' {--insert : Insert new entries}'
								. ' {--clean : Clean records}'
								. ' {--fix : Fix records}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Outcomes from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("outcomes started...");

		if (true === $this->options()['insert'])
			$this->insert();

		elseif (true === $this->options()['clean'])
			$this->clean();

		elseif (true === $this->options()['fix'])
			$this->fix();

		else {
			$this->clean();
			$this->insert();
		}

		$this->info("all outcomes completed");
	}

	/**
	 *
	 *
	 */

	private function fix()
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::table("{$main}.outcomes")
			->select([
				"{$main}.outcomes.id",
				"{$main}.outcomes.external_id",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$api}.outcome")
					->selectRaw(call_user_func(function () use ($main, $api) {
						$query = DB::table("{$main}.matches")
							->select("{$main}.matches.id")
							->whereColumn("{$main}.matches.external_id", "{$api}.outcome.objectFK")
							->where("{$api}.outcome.object", "?")
						;

						return "({$query->toSql()}) as `match_id`";
					}))
					->whereColumn("{$api}.outcome.id", "{$main}.outcomes.external_id")
				;

				return "({$query->toSql()}) as `match_id`";
			}), ['event'])

			->leftJoin("{$main}.matches", "{$main}.outcomes.match_id", "=", "{$main}.matches.id")
			->whereNull("{$main}.matches.id")
			->get()
		;

		$records->chunk(500)->each(function ($records) {
			$dataset = collect();
			foreach ($records as $record) {
				$data = [
					'id'			=> $record->id,
					'external_id'	=> $record->external_id,
					'match_id'		=> $record->match_id,
				];

				$dataset->push($data);

				$this->line("outcome {$data['external_id']} fixed");
			}

			DB::statement(""
				. "UPDATE"
					. " `outcomes`"
				. " SET"
					. " `match_id` = CASE `id`"
						. $dataset->map(function ($record) {
							return " WHEN {$record['id']} THEN '{$record['match_id']}'";
						})->implode(" ")
					. " END"
				. " WHERE"
					. " `id` IN ("
						. $dataset->map(function ($record) {
							return $record['id'];
						})->implode(",")
					. ")"
			);
		});
	}

	/**
	 *
	 *
	 */

	private function clean()
	{
		$main = config('database.connections.' . config('database.default') . '.database');

		$outcomes = DB::table("{$main}.outcomes")
			->selectRaw("COUNT({$main}.outcomes.id) as `qt`")
			->whereIn("{$main}.outcomes.match_id", function ($query) use ($main) {
				$query
					->select("{$main}.matches.id")
					->from("{$main}.matches")
					->whereExists(function ($query) use ($main) {
						$query
							->select("{$main}.matchstatuses.id")
							->from("{$main}.matchstatuses")
							->whereColumn("{$main}.matches.matchstatus_id", "{$main}.matchstatuses.id")
							->whereIn("{$main}.matchstatuses.slug", ["finished", "deleted", "cancelled"])
						;
					})
					->whereDate("{$main}.matches.started_at", "<", now()->subDay(7)->format('Y-m-d'))
				;
			})
			->first()
		;

		DB::table("{$main}.outcomes")
			->whereIn("{$main}.outcomes.match_id", function ($query) use ($main) {
				$query
					->select("{$main}.matches.id")
					->from("{$main}.matches")
					->whereExists(function ($query) use ($main) {
						$query
							->select("{$main}.matchstatuses.id")
							->from("{$main}.matchstatuses")
							->whereColumn("{$main}.matches.matchstatus_id", "{$main}.matchstatuses.id")
							->whereIn("{$main}.matchstatuses.slug", ["finished", "deleted", "cancelled"])
						;
					})
					->whereDate("{$main}.matches.started_at", "<", now()->subDay(7)->format('Y-m-d'))
				;
			})
			->delete()
		;

		$this->info("deleted {$outcomes->qt} outcomes");
	}

	/**
	 *
	 *
	 */

	private function insert()
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.outcome")
			->select([
				"{$api}.outcome.id",
				"{$api}.outcome.ut",
				"{$api}.outcome.del",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.matches")
					->select("{$main}.matches.id")
					->whereColumn("{$main}.matches.external_id", "{$api}.outcome.objectFK")
				;

				return "({$query->toSql()}) as match_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.outcometypes")
					->select("{$main}.outcometypes.id")
					->whereColumn("{$main}.outcometypes.external_id", "{$api}.outcome.outcome_typeFK")
				;

				return "({$query->toSql()}) as outcometype_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.outcomescopes")
					->select("{$main}.outcomescopes.id")
					->whereColumn("{$main}.outcomescopes.external_id", "{$api}.outcome.outcome_scopeFK")
				;

				return "({$query->toSql()}) as outcomescope_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.outcomesubtypes")
					->select("{$main}.outcomesubtypes.id")
					->whereColumn("{$main}.outcomesubtypes.external_id", "{$api}.outcome.outcome_subtypeFK")
				;

				return "({$query->toSql()}) as outcomesubtype_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.teams")
					->select("{$main}.teams.id")
					->whereColumn("{$main}.teams.external_id", "{$api}.outcome.iparam")
				;

				return "({$query->toSql()}) as team_id";
			}))
			->whereNotIn("{$api}.outcome.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.outcomes.external_id")
					->from("{$main}.outcomes")
					->whereNotNull("{$main}.outcomes.external_id")
				;
			})
			->where("{$api}.outcome.del", "no")
			->where("{$api}.outcome.object", "event")
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.matches")
					->select("{$main}.matches.id")
					->whereColumn("{$main}.matches.external_id", "{$api}.outcome.objectFK")
					->whereExists(function ($query) use ($main) {
						$query
							->select("{$main}.matchstatuses.id")
							->from("{$main}.matchstatuses")
							->whereColumn("{$main}.matches.matchstatus_id", "{$main}.matchstatuses.id")
							->whereNotIn("{$main}.matchstatuses.slug", ["?", "?", "?"])
						;
					})
				;

				return "({$query->toSql()}) IS NOT NULL";
			}), ["finished", "deleted", "cancelled"])
			->orderBy("{$api}.outcome.id", "asc")
			->get()
		;

		$records->chunk(500)->each(function ($records) {
			$dataset = collect();

			foreach ($records as $record) {
				$data = [
					'match_id'			=> $record->match_id,
					'outcometype_id'	=> $record->outcometype_id,
					'outcomescope_id'	=> $record->outcomescope_id,
					'outcomesubtype_id'	=> $record->outcomesubtype_id,
					'team_id'			=> $record->team_id,
					'external_id'		=> $record->id,
					'updated_at'		=> Carbon::parse($record->ut),
				];

				try {
					$validator = Validator::make($data, [
						'match_id'			=> 'required',
						'outcometype_id'	=> 'required',
						'outcomesubtype_id'	=> 'required',
						'outcomescope_id'	=> 'required',
						'external_id'		=> 'required|integer',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					$dataset->push($data);

					$this->line("outcome {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("outcome {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}

			// вставка
			DB::table('outcomes')->insert(
				$dataset->map(function ($record) {
					return [
						'created_at'		=> now(),
						'updated_at'		=> now(),
						'match_id'			=> $record['match_id'],
						'outcometype_id'	=> $record['outcometype_id'],
						'outcomescope_id'	=> $record['outcomescope_id'],
						'outcomesubtype_id'	=> $record['outcomesubtype_id'],
						'team_id'			=> $record['team_id'],
						'external_id'		=> $record['external_id'],
					];
				})->toArray()
			);
		});
	}
}
