<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class SeasonsCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:seasons';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Seasons from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("seasons started...");

		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		$records = DB::connection('api')
			->table("{$api}.tournament")
			->select([
				"{$api}.tournament.id",
				"{$api}.tournament.name as external_name",
				"{$api}.tournament.tournament_templateFK",
				"{$api}.language.name",
				"{$api}.tournament.ut",
				"{$api}.tournament.del",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.tournaments")
					->select("{$main}.tournaments.id")
					->whereColumn("{$main}.tournaments.external_id", "{$api}.tournament.tournament_templateFK")
					->whereExists(function ($query) use ($main) {
						$query
							->select("{$main}.sports.id")
							->from("{$main}.sports")
							->whereColumn("{$main}.sports.id", "{$main}.tournaments.sport_id")
							->where("{$main}.sports.has_odds", '?')
						;
					})
				;

				return "({$query->toSql()}) as tournament_id";
			}), [1])
			->leftJoin("{$api}.language", function ($query) use ($api) {
				$query
					->whereColumn("{$api}.language.objectFK", "{$api}.tournament.id")
					->where("{$api}.language.object", "tournament")
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
			->where("{$api}.tournament.del", "no")
			->whereNotIn("{$api}.tournament.id", function ($query) use ($main) {
				$query
					->select("{$main}.seasons.external_id")
					->from("{$main}.seasons")
					->whereNotNull("{$main}.seasons.external_id")
				;
			})
			->whereRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.tournaments")
					->select("{$main}.tournaments.id")
					->whereColumn("{$main}.tournaments.external_id", "{$api}.tournament.tournament_templateFK")
					->whereExists(function ($query) use ($main) {
						$query
							->select("{$main}.sports.id")
							->from("{$main}.sports")
							->whereColumn("{$main}.sports.id", "{$main}.tournaments.sport_id")
							->where("{$main}.sports.has_odds", '?')
						;
					})
				;

				return "({$query->toSql()}) IS NOT NULL";
			}), [1])
			->get()
		;

		foreach ($records as $record) {
			$data = [
				'name'			=> $record->name ?? $record->external_name,
				'tournament_id'	=> $record->tournament_id,
				'external_id'	=> $record->id,
				'external_name'	=> $record->external_name,
				'updated_at'	=> Carbon::parse($record->ut),
			];

			// если есть запись
			//if (null !== ($season = \App\Season::where('external_id', $data['external_id'])->first())) {
				// когда была обновлена запись (если дата в базе лары старее
				// даты из апи базы)
			//}

			// если нет
			//else {
				try {
					$validator = Validator::make($data, [
						'tournament_id'	=> 'required',
						'name'			=> 'required|min:2|max:255|unique_with:seasons,tournament_id',
						'external_id'	=> 'required|integer|unique:seasons,external_id',
					]);

					if ($validator->fails()) {
						// если ошибка одна и касается имени
						if ($validator->errors()->count() == 1 && $validator->errors()->has('name')) {
							// проверяем не локализованное имя
							$data['name'] = $data['external_name'];
							$validator = Validator::make($data, [
								'name' => 'required|min:2|max:255|unique_with:seasons,tournament_id',
							]);

							// если оно тоже есть в БД
							if ($validator->fails())
								throw new \Exception(implode('; ', $validator->errors()->all()));
						}

						// если ошибок несколько
						else
							throw new \Exception(implode('; ', $validator->errors()->all()));
					}

					$season = new \App\Season;
					$season->name			= $data['name'];
					$season->tournament_id	= $data['tournament_id'];
					$season->external_id	= $data['external_id'];
					$season->save();

					$this->line("season {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("season {$data['external_id']} failed with error: " . $e->getMessage());
				}
			//}
		}

		$this->info("all seasons completed");
	}
}
