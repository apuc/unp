<?php

namespace App\Console\Import;

use Illuminate\Console\Command;
use Facades\App\Services\Hash;
use DB;
use Carbon\Carbon;
use Validator;
use App\Traits\LoggableCommand;

class SportsCommand extends Command
{
    use LoggableCommand;
	
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */

	protected $signature =	'import:sports';

	/**
	 * The console command description.
	 *
	 * @var string
	 */

	protected $description = 'Import Sports from Enetpulse SpoCoSy database';

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */

	public function handle()
	{
		$this->info("sports started...");

		$records = DB::connection('api')
			->table('sport')
			->select([
				'sport.id',
				'sport.name as external_name',
				'language.name',
				'sport.ut',
			])
			->leftJoin('language', function ($query) {
				$query
					->whereColumn('language.objectFK', 'sport.id')
					->where('language.object', 'sport')
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
			->where('sport.del', 'no')
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
			if (null !== ($sport = \App\Sport::where('external_id', $data['external_id'])->first())) {
				// когда была обновлена запись (если дата в базе лары старее
				// даты из апи базы)
				/*
				if ($sport->updated_at->timestamp < $data['updated_at']->timestamp) {
					try {
						$validator = Validator::make($data, [
							'name' 			=> 'required|min:2|max:255|unique:sports,name,' . $sport->id,
							'slug' 			=> 'required|min:2|max:255|unique:sports,slug,' . $sport->id,
							'external_name'	=> 'required|min:2|max:255|unique:sports,external_name,' . $sport->id,
						]);

						if ($validator->fails())
							throw new \Exception(implode('; ', $validator->errors()->all()));

						$sport->name			= $data['name'];
						$sport->slug			= $data['slug'];
						$sport->external_name	= $data['external_name'];
						$sport->save();

						$this->line("sport {$data['external_id']} updated");
					}
					catch (\Exception $e) {
						$this->error("sport {$data['external_id']} failed with error: " . $e->getMessage());
					}
				}
				*/
			}

			// если нет
			else {
				try {
					$validator = Validator::make($data, [
						'name' 			=> 'required|min:2|max:255|unique:sports,name',
						'slug' 			=> 'required|min:2|max:255|unique:sports,slug',
						'external_id'	=> 'required|integer|unique:sports,external_id',
						'external_name'	=> 'required|min:2|max:255|unique:sports,external_name',
					]);

					if ($validator->fails())
						throw new \Exception(implode('; ', $validator->errors()->all()));

					$sport = new \App\Sport;
					$sport->name			= $data['name'];
					$sport->slug			= $data['slug'];
					$sport->external_id		= $data['external_id'];
					$sport->external_name	= $data['external_name'];
					$sport->is_enabled		= 1;
					$sport->save();

					$this->line("sport {$data['external_id']} imported");
				}
				catch (\Exception $e) {
					$this->error("sport {$data['external_id']} failed with error: " . $e->getMessage());
				}
			}
		}

		$this->info("all sports completed");
	}
}
