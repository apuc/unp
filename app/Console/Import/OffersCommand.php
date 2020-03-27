<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class OffersCommand extends Command
{
    use LoggableCommand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:offers'
								. ' {--insert : Insert new entries}'
								. ' {--update : Update records}';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Offers from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("offers started...");

		if (true === $this->options()['insert'])
			$this->insert();

		elseif (true === $this->options()['update'])
			$this->update();

		else {
			$this->update();
			$this->insert();
		}

		$this->info("all offers completed");
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
			->table("{$api}.bettingoffer")
			->select([
				"{$api}.bettingoffer.id",
				"{$api}.bettingoffer.odds",
				"{$api}.bettingoffer.odds_old",
				"{$api}.bettingoffer.couponKey",
				"{$api}.bettingoffer.ut",
				"{$api}.bettingoffer.del",
			])
			->selectRaw(call_user_func(function () use ($api) {
				$query = DB::table("{$api}.outcome")
					->select("{$api}.outcome.objectFK")
					->whereColumn("{$api}.outcome.id", "{$api}.bettingoffer.outcomeFK")
				;

				return "({$query->toSql()}) as event_id";
			}))
			->selectRaw(call_user_func(function () use ($api) {
				$query = DB::table("{$api}.outcome_type")
					->select("{$api}.outcome_type.name")
					->where("{$api}.outcome_type.id", function ($query) use ($api) {
						$query
							->select("{$api}.outcome.outcome_typeFK")
							->from("{$api}.outcome")
							->whereColumn("{$api}.outcome.id", "{$api}.bettingoffer.outcomeFK")
						;
					});
				;

				return "({$query->toSql()}) as type";
			}))
			->selectRaw(call_user_func(function () use ($api) {
				$query = DB::table("{$api}.outcome_scope")
					->select("{$api}.outcome_scope.name")
					->where("{$api}.outcome_scope.id", function ($query) use ($api) {
						$query
							->select("{$api}.outcome.outcome_scopeFK")
							->from("{$api}.outcome")
							->whereColumn("{$api}.outcome.id", "{$api}.bettingoffer.outcomeFK")
						;
					});
				;

				return "({$query->toSql()}) as scope";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.bookmakers")
					->select("{$main}.bookmakers.id")
					->whereColumn("{$main}.bookmakers.external_id", "{$api}.bettingoffer.odds_providerFK")
					->where("{$main}.bookmakers.is_enabled", "?")
				;

				return "({$query->toSql()}) as bookmaker_id";
			}), [1])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.outcomes")
					->select("{$main}.outcomes.id")
					->whereColumn("{$main}.outcomes.external_id", "{$api}.bettingoffer.outcomeFK")
				;

				return "({$query->toSql()}) as outcome_id";
			}))
			->whereNotIn("{$api}.bettingoffer.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.offers.external_id")
					->from("{$main}.offers")
					->whereNotNull("{$main}.offers.external_id")
				;
			})
			->where("{$api}.bettingoffer.del", "no")
			->where("{$api}.bettingoffer.active", "yes")
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.bookmakers")
					->select("{$main}.bookmakers.id")
					->whereColumn("{$main}.bookmakers.external_id", "{$api}.bettingoffer.odds_providerFK")
					->where("{$main}.bookmakers.is_enabled", "?")
				;

				return "({$query->toSql()}) IS NOT NULL";
			}), [1])
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.outcomes")
					->select("{$main}.outcomes.id")
					->whereColumn("{$main}.outcomes.external_id", "{$api}.bettingoffer.outcomeFK")
				;

				return "({$query->toSql()}) IS NOT NULL";
			}))
			->get()
		;

		$events = collect();
		$records->chunk(500)->each(function ($records) use ($events) {
			$dataset = collect();

			foreach ($records as $record) {
				$data = [
					'bookmaker_id'		=> $record->bookmaker_id,
					'outcome_id'		=> $record->outcome_id,
					'odds_current'		=> $record->odds,
					'odds_old'			=> $record->odds_old,
					'coupon'			=> $record->couponKey,
					'external_id'		=> $record->id,
					'updated_at'		=> Carbon::parse($record->ut),
				];

				try {
					// если в $dataset уже содержится запись с bookmaker_id и outcome_id
					if (
						$dataset->filter(function ($row) use ($data) {
							return $row['bookmaker_id'] == $data['bookmaker_id'] && $row['outcome_id'] == $data['outcome_id'];
						})->count()
					)
						// обрываем итерацию
						throw new \Exception(trans('validation.unique', [
							'attribute' => implode(', ', [
								trans('validation.attributes.outcome_id'),
								trans('validation.attributes.bookmaker_id'),
							]),
						]));

					$validator = Validator::make($data, [
						'bookmaker_id'	=> 'required',
						'outcome_id'	=> 'required|unique_with:offers,bookmaker_id',
						'odds_current'	=> 'required|numeric',
						'odds_old'		=> 'required|numeric',
						'coupon'		=> 'nullable|max:255',
						'external_id'	=> 'required|integer',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					$dataset->push($data);

					// если
					if (
						// в массиве нет матча
							!$events->filter(function ($event) use ($record) {
								return $event === $record->event_id;
							})->count()
						// и тип коэффициента 1x2
						&&	$record->type == '1x2'
						// и масштаб коэффициента ord
						&&	$record->scope == 'ord'
					)
						// запоминаем матч, для последующего обновление коэффициентов
						// у него
						$events->push($record->event_id);

					$this->line("offer {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("offer {$data['external_id']} failed with errors: " . $e->getMessage());
				}
			}

			// вставка
			DB::table('offers')->insert(
				$dataset->map(function ($record) {
					return [
						'created_at'	=> now(),
						'updated_at'	=> now(),
						'bookmaker_id'	=> $record['bookmaker_id'],
						'outcome_id'	=> $record['outcome_id'],
						'odds_current'	=> $record['odds_current'],
						'odds_old'		=> $record['odds_old'],
						'coupon'		=> $record['coupon'],
						'external_id'	=> $record['external_id'],
						'has_offers'	=> 1,
					];
				})->toArray()
			);
		});

		// если есть матчи
		if ($events->count())
			// обновляем коэффициенты матчей
			$this->updateOddsForMatches($events);
	}

	/**
	 *
	 *
	 */

	private function update()
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.bettingoffer")
			->select([
				"{$api}.bettingoffer.id",
				"{$api}.bettingoffer.odds",
				"{$api}.bettingoffer.odds_old",
				"{$api}.bettingoffer.couponKey",
				"{$api}.bettingoffer.ut",
				"{$api}.bettingoffer.del",
				"{$api}.bettingoffer.active",
			])
			->selectRaw(call_user_func(function () use ($api) {
				$query = DB::table("{$api}.outcome")
					->select("{$api}.outcome.objectFK")
					->whereColumn("{$api}.outcome.id", "{$api}.bettingoffer.outcomeFK")
				;

				return "({$query->toSql()}) as event_id";
			}))
			->selectRaw(call_user_func(function () use ($api) {
				$query = DB::table("{$api}.outcome_type")
					->select("{$api}.outcome_type.name")
					->where("{$api}.outcome_type.id", function ($query) use ($api) {
						$query
							->select("{$api}.outcome.outcome_typeFK")
							->from("{$api}.outcome")
							->whereColumn("{$api}.outcome.id", "{$api}.bettingoffer.outcomeFK")
						;
					});
				;

				return "({$query->toSql()}) as type";
			}))
			->selectRaw(call_user_func(function () use ($api) {
				$query = DB::table("{$api}.outcome_scope")
					->select("{$api}.outcome_scope.name")
					->where("{$api}.outcome_scope.id", function ($query) use ($api) {
						$query
							->select("{$api}.outcome.outcome_scopeFK")
							->from("{$api}.outcome")
							->whereColumn("{$api}.outcome.id", "{$api}.bettingoffer.outcomeFK")
						;
					});
				;

				return "({$query->toSql()}) as scope";
			}))
			->whereIn("{$api}.bettingoffer.id", function ($query) use ($main, $api) {
				$query
					->select("{$main}.offers.external_id")
					->from("{$main}.offers")
					->whereNotNull("{$main}.offers.external_id")
				;
			})
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.offers")
					->select("{$main}.offers.updated_at")
					->whereColumn("{$main}.offers.external_id", "{$api}.bettingoffer.id")
				;

				return "{$api}.bettingoffer.ut > ({$query->toSql()})";
			}))
			->get()
		;

		$events = collect();
		$records->chunk(500)->each(function ($records) use ($events) {
			$dataset = collect();

			foreach ($records as $record) {
				$data = [
					'odds_current'	=> $record->odds,
					'odds_old'		=> $record->odds_old,
					'ut'			=> Carbon::parse($record->ut),
					'external_id'	=> $record->id,
					'has_offers'	=> $record->active == 'yes' ? 1 : 0,
				];

				try {
					$validator = Validator::make($data, [
						'odds_current'	=> 'required|numeric',
						'odds_old'		=> 'required|numeric',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					$dataset->push($data);

					// если
					if (
						// в массиве нет матча
							!$events->filter(function ($event) use ($record) {
								return $event === $record->event_id;
							})->count()
						// и тип коэффициента 1x2
						&&	$record->type == '1x2'
						// и масштаб коэффициента ord
						&&	$record->scope == 'ord'
					)
						// запоминаем матч, для последующего обновление коэффициентов
						// у него
						$events->push($record->event_id);

					// обновление
					$this->line("offer {$data['external_id']} updated");
				}
				catch (\Exception $e) {
					$this->error("offer {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}

			DB::statement(""
				. "UPDATE"
					. " `offers`"
				. " SET"
					// время апдейта
					. " `updated_at` = '" . now() ."',"

					// выбранный коэффициент
					. " `odds_current` = CASE `external_id`"
						. $dataset->map(function ($record) {
							return " WHEN {$record['external_id']} THEN '{$record['odds_current']}'";
						})->implode(" ")
					. " END,"

					// старый коэффициент
					. " `odds_old` = CASE `external_id`"
						. $dataset->map(function ($record) {
							return " WHEN {$record['external_id']} THEN '{$record['odds_old']}'";
						})->implode(" ")
					. " END,"

					// активность
					. " `has_offers` = CASE `external_id`"
						. $dataset->map(function ($record) {
							return " WHEN {$record['external_id']} THEN '{$record['has_offers']}'";
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

		// если есть матчи
		if ($events->count())
			// обновляем коэффициенты матчей
			$this->updateOddsForMatches($events);
	}

	/**
	 *
	 *
	 */

	private function updateOddsForMatches($events)
	{
		// режем по 500 матчей
		$events->chunk(500)->each(function ($events) {
			// получаем исходы матчей
			$outcomes	= $this->getOutcomes($events);
			$dataset	= collect();

			// формируем массив данных
			foreach ($events as $event) {
				$data = [
					'odds1_current'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == 1)
								return $outcome->odds_current;

						return null;
					}),
					'odds1_old'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == 1)
								return $outcome->odds_old;

						return null;
					}),
					'bookmaker1_id'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == 1)
								return $outcome->bookmaker_id;

						return null;
					}),

					//////////////

					'oddsx_current'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == null)
								return $outcome->odds_current;

						return null;
					}),
					'oddsx_old'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == null)
								return $outcome->odds_old;

						return null;
					}),
					'bookmakerx_id'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == null)
								return $outcome->bookmaker_id;

						return null;
					}),

					//////////////

					'odds2_current'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == 2)
								return $outcome->odds_current;

						return null;
					}),
					'odds2_old'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == 2)
								return $outcome->odds_old;

						return null;
					}),
					'bookmaker2_id'		=> call_user_func(function () use ($outcomes, $event) {
						foreach ($outcomes->filter(function ($outcome) use ($event) {
							return $outcome->event_id == $event;
						}) as $outcome)
							if ($outcome->number == 2)
								return $outcome->bookmaker_id;

						return null;
					}),

					//////////////

					'external_id'		=> $event,
				];

				// если есть хотя бы 1 коэффициент
				if (
						!is_null($data['odds1_current']) || !is_null($data['odds1_old']) || !is_null($data['bookmaker1_id'])
					||	!is_null($data['oddsx_current']) || !is_null($data['oddsx_old']) || !is_null($data['bookmakerx_id'])
					||	!is_null($data['odds2_current']) || !is_null($data['odds2_old']) || !is_null($data['bookmaker2_id'])
				)
					// запоминаем элемент с данными
					$dataset->push($data);
			}

			// если есть данные для обновления
			if ($dataset->count())
				// строим и исполняем запрос
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
	}

	/**
	 *
	 *
	 */

	private function getOutcomes($events)
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		return DB::connection('api')
			->table("{$api}.outcome")

			// event_id
			->select([
				"{$api}.outcome.objectFK as event_id"
			])

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
			->whereIn("{$api}.outcome.objectFK", $events->toArray())
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
}
