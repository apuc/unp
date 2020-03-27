<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class CountriesCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:countries';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Countries from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("countries started...");

		$records = DB::connection('api')
			->table('country')
			->select([
				'country.id',
				'country.name as external_name',
				'language.name',
				'country.ut',
				'country.del',
			])
			->leftJoin('language', function ($query) {
				$query
					->whereColumn('language.objectFK', 'country.id')
					->where('language.object', 'country')
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
			->where('country.del', 'no')
			->get()
		;

		foreach ($records as $record) {
			$data = [
				'name'			=> $record->name ?? $record->external_name,
				'slug'			=> str_slug($record->external_name),
				'external_id'	=> $record->id,
				'external_name'	=> $record->external_name,
				'updated_at'	=> Carbon::parse($record->ut),
			];

			// если есть запись
			if (null !== ($country = \App\Country::where('external_id', $data['external_id'])->first())) {
				// когда была обновлена запись (если дата в базе лары старее
				// даты из апи базы)
				/*
				if ($country->updated_at->timestamp < $data['updated_at']->timestamp) {
					try {
						$validator = Validator::make($data, [
							'name' 			=> 'required|min:2|max:255|unique:countries,name,' . $country->id,
							'slug' 			=> 'required|min:2|max:255|unique:countries,slug,' . $country->id,
							'external_name'	=> 'required|min:2|max:255|unique:countries,external_name,' . $country->id,
						]);

						if ($validator->fails())
							throw new \Exception(implode('; ', $validator->errors()->all()));

						$country->name			= $data['name'];
						$country->slug			= $data['slug'];
						$country->external_name	= $data['external_name'];
						$country->save();

						$this->line("country {$data['external_id']} updated");
					}
					catch (\Exception $e) {
						$this->error("country {$data['external_id']} failed with error: " . $e->getMessage());
					}
				}
				*/
			}

			// если нет
			else {
				try {
					$validator = Validator::make($data, [
						'name' 			=> 'required|min:2|max:255|unique:countries,name',
						'slug' 			=> 'required|min:2|max:255|unique:countries,slug',
						'external_id'	=> 'required|integer|unique:countries,external_id',
						'external_name'	=> 'required|min:2|max:255|unique:countries,external_name',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					$country = new \App\Country;
					$country->name			= $data['name'];
					$country->slug			= $data['slug'];
					$country->external_id	= $data['external_id'];
					$country->external_name	= $data['external_name'];
					$country->is_enabled	= 1;
					$country->save();

					$this->line("country {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("country {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}
		}

		$this->info("all countries completed");
	}
}
