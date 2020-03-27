<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class TournamentsCommand extends Command
{
    use LoggableCommand;

	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:tournaments';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Tournaments from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("tournaments started");

		$records = DB::connection('api')
			->table('tournament_template')
			->select([
				'tournament_template.id',
				'tournament_template.name as external_name',
				'language.name',
				'tournament_template.sportFK',
				'tournament_template.gender',
				'tournament_template.ut',
				'tournament_template.del',
			])
			->leftJoin('language', function ($query) {
				$query
					->whereColumn('language.objectFK', 'tournament_template.id')
					->where('language.object', 'tournament_template')
					->where('language.del', 'no')
					->whereExists(function ($query) {
						$query
							->select('language_type.id')
							->from('language_type')
							->whereColumn('language_type.id', 'language.language_typeFK')
							->where('language_type.name', config('app.locale'))
							->where('language_type.del', 'no')
						;
					})
				;
			})
			->where('tournament_template.del', 'no')
			->get()
		;

		$genders	= \App\Gender::get();
		$sports		= \App\Sport::get();

		foreach ($records as $record) {
			$data = [
				'name'			=> $record->name ?? $record->external_name,
				'sport_id'		=> call_user_func(function () use ($sports, $record) {
					foreach ($sports as $sport)
						if ($record->sportFK == $sport->external_id)
							return $sport->id;

					return null;
				}),
				'gender_id'		=> call_user_func(function () use ($genders, $record) {
					foreach ($genders as $gender)
						if ($record->gender == $gender->slug)
							return $gender->id;

					return null;
				}),
				'external_id'	=> $record->id,
				'external_name'	=> $record->external_name,
				'is_enabled'	=> $record->del == 'no' ? 1 : 0,
				'updated_at'	=> Carbon::parse($record->ut),
			];

			// если есть запись
			if (null !== ($tournament = \App\Tournament::where('external_id', $data['external_id'])->first())) {
				// когда была обновлена запись (если дата в базе лары старее
				// даты из апи базы)
				/*
				if ($tournament->updated_at->timestamp < $data['updated_at']->timestamp) {
					try {
						$validator = Validator::make($data, [
							'sport_id'			=> 'required|exists:sports,id',
							'gender_id'			=> 'required|exists:genders,id',
							'name' 				=> 'required|min:2|max:255|unique_with:tournaments,sport_id,gender_id,' . $tournament->id,
						]);

						if ($validator->fails())
							throw new \Exception(implode('; ', $validator->errors()->all()));

						$tournament->sport_id	= $data['sport_id'];
						$tournament->gender_id	= $data['gender_id'];
						$tournament->name		= $data['name'];
						$tournament->save();

						$this->line("tournament {$data['external_id']} updated");
					}
					catch (\Exception $e) {
						$this->error("tournament {$data['external_id']} failed with error: " . $e->getMessage());
					}
				}
				*/
			}

			// если нет
			else {
				try {
					$validator = Validator::make($data, [
						'sport_id'			=> 'required',
						'gender_id'			=> 'required',
						'name'				=> 'required|min:2|max:255|unique_with:tournaments,sport_id,gender_id',
						'external_id'		=> 'required|integer|unique:tournaments,external_id',
					]);

					if ($validator->fails()) {
						// если ошибка одна и касается имени
						if ($validator->errors()->count() == 1 && $validator->errors()->has('name')) {
							// проверяем не локализованное имя
							$data['name'] = $data['external_name'];
							$validator = Validator::make($data, [
								'name' => 'required|min:2|max:255|unique_with:tournaments,sport_id,gender_id',
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

					$tournament = new \App\Tournament;
					$tournament->name			= $data['name'];
					$tournament->sport_id		= $data['sport_id'];
					$tournament->gender_id		= $data['gender_id'];
					$tournament->external_id	= $data['external_id'];
					$tournament->save();

					$this->line("tournament {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("tournament {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}
		}

		$this->info("tournaments completed");
	}
}
