<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class ParticipantsCommand extends Command
{
    use LoggableCommand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:participants'
								. ' {--insert : Insert new entries}'
								. ' {--update : Update records}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Participants from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("participants started...");

		if (true === $this->options()['insert'])
			$this->insert();

		elseif (true === $this->options()['update'])
			$this->update();

		else {
			$this->update();
			$this->insert();
		}

		$this->info("all participants completed");
	}

	/**
	 *
	 *
	 *
	 */

	private function insert()
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.event_participants")
			->select([
				"{$api}.event_participants.id",
				"{$api}.event_participants.number",
				"{$api}.event_participants.ut",
				"{$api}.event_participants.del",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.teams")
					->select("{$main}.teams.id")
					->whereColumn("{$main}.teams.external_id", "{$api}.event_participants.participantFK")
				;

				return "({$query->toSql()}) as team_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.matches")
					->select("{$main}.matches.id")
					->whereColumn("{$main}.matches.external_id", "{$api}.event_participants.eventFK")
				;

				return "({$query->toSql()}) as match_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$api}.result")
					->select("{$api}.result.value")
					->whereColumn("{$api}.result.event_participantsFK", "{$api}.event_participants.id")
					->where("{$api}.result.del", "?")
					->where("{$api}.result.value", ">=", "0")
					->orderBy("{$api}.result.ut", "DESC")
					->take(1)
				;

				return "({$query->toSql()}) as score";
			}), ['no', '0'])
			->whereNotIn("{$api}.event_participants.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.participants.external_id")
					->from("{$main}.participants")
					->whereNotNull("{$main}.participants.external_id")
				;
			})
			->where("{$api}.event_participants.del", "no")
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.teams")
					->select("{$main}.teams.id")
					->whereColumn("{$main}.teams.external_id", "{$api}.event_participants.participantFK")
				;

				return "({$query->toSql()}) IS NOT NULL";
			}))
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.matches")
					->select("{$main}.matches.id")
					->whereColumn("{$main}.matches.external_id", "{$api}.event_participants.eventFK")
				;

				return "({$query->toSql()}) IS NOT NULL";
			}))
			->get()
		;

		$records->chunk(500)->each(function ($records) {

			$dataset = collect();

			foreach ($records as $record) {
				$data = [
					'team_id'		=> $record->team_id,
					'match_id'		=> $record->match_id,
					'score'			=> $record->score,
					'position'		=> $record->number,
					'external_id'	=> $record->id,
					'updated_at'	=> Carbon::parse($record->ut),
				];

				try {
					$validator = Validator::make($data, [
						'team_id'		=> 'required',
						'match_id'		=> 'required',
						'score' 		=> 'nullable',
						'external_id'	=> 'required',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					$dataset->push($data);

					$this->line("participant {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("participant {$data['external_id']} failed with errors: " . $e->getMessage());
				}
			}

			// вставка
			DB::table('participants')->insert(
				$dataset->map(function ($record) {
					return [
						'created_at'	=> now(),
						'updated_at'	=> now(),
						'team_id'		=> $record['team_id'],
						'match_id'		=> $record['match_id'],
						'score'			=> $record['score'],
						'position'		=> $record['position'],
						'external_id'	=> $record['external_id'],
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
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.event_participants")
			->select([
				"{$api}.event_participants.id",
				"{$api}.event_participants.number",
				"{$api}.event_participants.eventFK",
				"{$api}.event_participants.ut",
				"{$api}.event_participants.del",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$api}.result")
					->select("{$api}.result.value")
					->whereColumn("{$api}.result.event_participantsFK", "{$api}.event_participants.id")
					->where("{$api}.result.del", "?")
					->where("{$api}.result.value", "<>", "?")
					->orderBy("{$api}.result.ut", "DESC")
					->take(1)
				;

				return "({$query->toSql()}) as score";
			}), ['no', ''])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.participants")
					->select("{$main}.participants.id")
					->from("{$main}.participants")
					->whereColumn("{$api}.event_participants.id", "{$main}.participants.external_id")
				;

				return "({$query->toSql()}) as participant_id";
			}))
			->whereIn("{$api}.event_participants.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.participants.external_id")
					->from("{$main}.participants")
					->whereNotNull("{$main}.participants.external_id")
				;
			})
			->where("{$api}.event_participants.del", "no")
			->whereRaw(call_user_func(function () use ($main, $api) {
				$apiResult = DB::table("{$api}.result")
					->select("{$api}.result.value")
					->whereColumn("{$api}.result.event_participantsFK", "{$api}.event_participants.id")
					->where("{$api}.result.del", "?")
					->where("{$api}.result.value", '<>', "?")
					->orderBy("{$api}.result.ut", "DESC")
					->take(1)
				;

				$mainResult = DB::table("{$main}.participants")
					->select("{$main}.participants.score")
					->whereColumn("{$main}.participants.external_id", "{$api}.event_participants.id")
				;

				$mainUt = DB::table("{$main}.participants")
					->select("{$main}.participants.updated_at")
					->whereColumn("{$main}.participants.external_id", "{$api}.event_participants.id")
				;

				return <<<SQL
					(
						({$apiResult->toSql()}) <> ({$mainResult->toSql()})
						OR
						`{$api}`.`event_participants`.`ut` > ({$mainUt->toSql()})
					)
SQL;
			}), ['no', ''])
			->get()
		;

		$exceptions = collect();

		$records->chunk(500)->each(function ($records) use ($exceptions) {
			foreach ($records as $record) {
				$data = [
					'id'				=> $record->participant_id,
					'score'				=> $record->score,
					'position'			=> $record->number,
					'event_id'			=> $record->eventFK,
					'external_id'		=> $record->id,
					'updated_at'		=> Carbon::parse($record->ut),
				];

				try {
					$validator = Validator::make($data, [
						'score' 		=> 'nullable',
						'external_id'	=> 'required',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					try {
						// обновление
						DB::table('participants')->where('id', $data['id'])->update([
							'updated_at'	=> now(),
							'score'			=> $data['score'],
							'position'		=> $data['position'],
						]);
					}
					// в случае ислючения
					catch (\Exception $e) {
						// сохраняем запись для последующего точеченого обновления

						// если в исключениях НЕ существует коллекция матча
						if (!$exceptions->has($data['event_id']))
							// создаем ее
							$exceptions->put($data['event_id'], collect());

						// заполняем участником
						$exceptions->get($data['event_id'])->push($data);
					}

					$this->line("participant {$data['external_id']} updated");
				}
				catch (\Exception $e) {
					$this->error("participant {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}
		});

		// если есть исключения
		if ($exceptions->count()) {
			$exceptions->each(function ($exception, $event_id) {
				// если в исключение только один участник
				if ($exception->count() < 2) {
					// отыскиваем второго
					$match = \App\Match::query()
						->with([
							'participants' => function ($query) use ($exception) {
								$query->where('id', '<>', $exception->first()['id']);
							},
						])
						->where('external_id', $event_id)
						->first();

					// запоминаем второго участника (исправляя ему position)
					$exception->push([
						'id'				=> $match->participants->first()->id,
						'score'				=> $match->participants->first()->score,
						'position'			=> $exception->first()['position'] == 2 ? 1 : 2,
						'event_id'			=> $event_id,
						'external_id'		=> $match->participants->first()->external_id,
						'updated_at'		=> null,
					]);
				}
			});

			// формируем запрос на обновление
			DB::statement(""
				. "INSERT INTO"
					. " `participants`"
						. " ("
							. " `id`,"
							. " `updated_at`,"
							. " `score`,"
							. " `position`"
						. " )"
					. " VALUES"
						. $exceptions->map(function ($exception) {
							return ""
								. "("
									. "'" . $exception->first()['id'] . "',"
									. "'" . now()->format('Y-m-d H:i:s') . "',"
									. "'" . $exception->first()['score'] . "',"
									. "'0'"
								. "),"
								. "("
									. "'" . $exception->last()['id'] . "',"
									. "'" . now()->format('Y-m-d H:i:s') . "',"
									. "'" . $exception->last()['score'] . "',"
									. "'" . $exception->last()['position'] . "'"
								. "),"
								. "("
									. "'" . $exception->first()['id'] . "',"
									. "'" . now()->format('Y-m-d H:i:s') . "',"
									. "'" . $exception->first()['score'] . "',"
									. "'" . $exception->first()['position'] . "'"
								. ")"
							;
						})->implode(",")
					. " ON DUPLICATE KEY UPDATE"
						. " `updated_at` = VALUES(`updated_at`),"
						. " `score` = VALUES(`score`),"
						. " `position` = VALUES(`position`)"
			);
		}
	}
}
