<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class StagesCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:stages';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Stages from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("stages started...");

		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection("api")
			->table("{$api}.tournament_stage")
			->select([
				"{$api}.tournament_stage.id",
				"{$api}.tournament_stage.name as external_name",
				"{$api}.tournament_stage.tournamentFK",
				"{$api}.tournament_stage.gender",
				"{$api}.tournament_stage.countryFK",
				"{$api}.language.name",
				"{$api}.tournament_stage.ut",
				"{$api}.tournament_stage.del",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.seasons")
					->select("{$main}.seasons.id")
					->whereColumn("{$main}.seasons.external_id", "{$api}.tournament_stage.tournamentFK")
				;

				return "({$query->toSql()}) as season_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.countries")
					->select("{$main}.countries.id")
					->whereColumn("{$main}.countries.external_id", "{$api}.tournament_stage.countryFK")
				;

				return "({$query->toSql()}) as country_id";
			}))
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.genders")
					->select("{$main}.genders.id")
					->whereColumn("{$main}.genders.slug", "{$api}.tournament_stage.gender")
				;

				return "({$query->toSql()}) as gender_id";
			}))
			->leftJoin("{$api}.language", function ($query) use ($api) {
				$query
					->whereColumn("{$api}.language.objectFK", "{$api}.tournament_stage.id")
					->where("{$api}.language.object", "tournament_stage")
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
			->where("{$api}.tournament_stage.del", "no")
			->whereNotIn("{$api}.tournament_stage.id", function ($query) use ($main) {
				$query
					->select("{$main}.stages.external_id")
					->from("{$main}.stages")
					->whereNotNull("{$main}.stages.external_id")
				;
			})
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.seasons")
					->select("{$main}.seasons.id")
					->whereColumn("{$main}.seasons.external_id", "{$api}.tournament_stage.tournamentFK")
				;

				return "({$query->toSql()}) IS NOT NULL";
			}))
			->get()
		;

		foreach ($records as $record) {
			$data = [
				'name'			=> $record->name ?? $record->external_name,
				'season_id'		=> $record->season_id,
				'gender_id'		=> $record->gender_id,
				'country_id'	=> $record->country_id,
				'external_id'	=> $record->id,
				'external_name'	=> $record->external_name,
				'updated_at'	=> Carbon::parse($record->ut),
			];

			// если есть запись
			//if (null !== ($stage = \App\Stage::where('external_id', $data['external_id'])->first())) {
				// когда была обновлена запись (если дата в базе лары старее
				// даты из апи базы)
			//}

			// если нет
			//else {
				try {
					$validator = Validator::make($data, [
						'season_id'		=> 'required',
						'gender_id'		=> 'required',
						'country_id'	=> 'required',
						'name'			=> 'required|min:2|max:255|unique_with:stages,country_id,season_id,gender_id',
						'external_id'	=> 'required|integer|unique:stages,external_id',
					]);

					if ($validator->fails()) {
						// если ошибка одна и касается имени
						if ($validator->errors()->count() == 1 && $validator->errors()->has('name')) {

							// проверяем нелокализованное имя
							$data['name'] = $data['external_name'];
							$validator = Validator::make($data, [
								'name' => 'required|min:2|max:255|unique_with:stages,country_id,season_id,gender_id',
							]);

							// если оно тоже есть в БД
							if ($validator->fails())
								// вываливаем исключение
								throw new \Exception(implode('; ', $validator->errors()->all()));
						}

						// если ошибок несколько вертаем исключение
						else
							throw new \Exception(implode('; ', $validator->errors()->all()));
					}

					$stage = new \App\Stage;
					$stage->name			= $data['name'];
					$stage->season_id		= $data['season_id'];
					$stage->gender_id		= $data['gender_id'];
					$stage->country_id		= $data['country_id'];
					$stage->external_id		= $data['external_id'];
					$stage->save();

					$this->line("stage {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("stage {$data['external_id']} failed with error: " . $e->getMessage());
				}
			//}
		}

		$this->info("all stages completed");
	}
}
