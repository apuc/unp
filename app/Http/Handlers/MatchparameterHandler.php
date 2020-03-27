<?php

namespace App\Http\Handlers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Facades\App\Queries\Site\Match\MatchesQuery;

class MatchparameterHandler extends ParameterHandler
{
	/**
	 * получаем данные матчей
	 *
	 * @return array
	 */

	public function query()
	{
		// центральные данные
		return call_user_func(function () {
			$dataset = collect(
				$dataset = MatchesQuery::where('date', $this->get('day', now()->format('Y-m-d')))->get()
			);

			// отфильтровываем по спорту
			if ($this->get('sport', false))
				$dataset = $dataset->filter(function ($data, $slug) {
					return $this->get('sport') == $slug;
				});

			// пересобираем массив без ассоциативных ключей + сортируем по алфавиту
			return $dataset->map(function ($sport, $slug) {
				$sport['slug'] = $slug;

				// собираем турниры с is_top
				$myliga = collect($sport['tournaments'])->filter(function ($tournament) {
					return $tournament['is_top'] == 1;
				})->map(function ($tournament, $id) {
					$tournament['id'] = $id;
					return $tournament;
				})->sortBy('position');

				// собираем другие лиги
				$otherliga = collect($sport['tournaments'])->filter(function ($tournament) {
					return $tournament['is_top'] != 1;
				})->map(function ($tournament, $id) {
					$tournament['id'] = $id;
					return $tournament;
				})->sortBy('name');

				$sport['tournaments']	= $myliga->merge($otherliga)->map(function ($tournament, $id) {

					// отфильтровываем по турниру
					if ($this->get('tournament', false))
						if ($this->get('tournament') != $tournament['id'])
							$tournament['matches'] = [];

					$tournament['matches']	= collect($tournament['matches'])->map(function ($match, $id) {
						$match['id'] = $id;
						return $match;
					})->filter(function ($match) {
						if (false === $this->get('status', false))
							return true;

						return $match['status_slug'] == $this->get('status');
					})->sortBy('time')->values()->toArray();

					return !empty($tournament['matches']) ? $tournament : [];
				})->filter(function ($tournament) {
					return !empty($tournament);
				})->toArray();

				return $sport;
			})->filter(function ($sport) {
				return !empty($sport['tournaments']);
			})->sortBy('position')->values()->toArray();
		});
	}

	/**
	 * подгрузчик параметров
	 *
	 * @param boolean $filterout
	 */

	public function boot($filterout = false)
	{
		$params	= $this->collectParams($filterout);

		// алгоритм подгрузки существующих параметров
		$this->set('topical', new MatchparameterHandler($this->request));

		foreach ($params as $type => $row) {
			$value = new MatchparameterHandler($this->request);
			$value->set('id',		$type);
			$value->set('values',	$row['values']);

			$this->get('topical')->set(
				$row['param'],
				is_null($row['values']) ? $row['values'] : $value
			);
		}
	}

	/**
	 * собирает коллекцию параметров с
	 * значениями
	 *
	 * @return collect
	 *
	 * @param boolean $filterout
	 */

	private function collectParams($filterout)
	{
		$collect = collect();

		// собираем дни
		$this->collectDay($collect);

		// собираем спорт
		$this->collectSport($collect);

		// собираем статусы
		$this->collectStatus($collect, $filterout);

		// собираем турниры
		$this->collectTournament($collect, $filterout);

		return $collect;
	}

	/**
	 * собирает дни
	 *
	 * @param collect $collect
	 */

	private function collectDay($collect)
	{
		$collect->put('days', collect([
			'param'		=> 'day',
			'values'	=> collect(),
		]));

		// предыдущие 7 дней
		for ($i = 7; $i >= 1; $i--) {
			$collect->get('days')->get('values')->push(collect([
				'name_format'	=> call_user_func(function () use ($i) {
					return now()->subDay($i)->format('d/m') . ' ' . trans('days.abb.' . now()->subDay($i)->format('w'));
				}),
				'name'			=> call_user_func(function () use ($i) {
					return now()->subDay($i)->format('d/m') . ' ' . trans('days.abb.' . now()->subDay($i)->format('w'));
				}),
				'value'			=> now()->subDay($i)->format('Y-m-d'),
				'current'		=> $this->isCurrent('day', now()->subDay($i)->format('Y-m-d')),
			]));
		}

		// сегодня
		$collect->get('days')->get('values')->push(collect([
			'name_format'	=> trans('days.now'),
			'name'			=> call_user_func(function () use ($i) {
				return now()->format('d/m') . ' ' . trans('days.abb.' . now()->format('w'));
			}),
			'value'			=> now()->format('Y-m-d'),
			'current'		=> call_user_func(function () {
				if (false === $this->get('day', false))
					return true;

				return $this->isCurrent('day', now()->format('Y-m-d'));
			}),
		]));

		// следующие 7 дней
		for ($i = 1; $i <= 7; $i++) {
			$collect->get('days')->get('values')->push(collect([
				'name_format'	=> call_user_func(function () use ($i) {
					return now()->addDay($i)->format('d/m') . ' ' . trans('days.abb.' . now()->addDay($i)->format('w'));
				}),
				'name'			=> call_user_func(function () use ($i) {
					return now()->addDay($i)->format('d/m') . ' ' . trans('days.abb.' . now()->addDay($i)->format('w'));
				}),
				'value'			=> now()->addDay($i)->format('Y-m-d'),
				'current'		=> $this->isCurrent('day', now()->addDay($i)->format('Y-m-d')),
			]));
		}
	}

	/**
	 * собирает спорт
	 *
	 * @param collect $collect
	 */

	private function collectSport($collect)
	{
		$dataset = MatchesQuery::where('date', $this->get('day', now()->format('Y-m-d')))->get();

		// виды спорта
		$sports = collect($dataset)->map(function ($data, $slug) {
			return [
				'id'		=> $data['id'],
				'slug'		=> $slug,
				'name'		=> $data['name'],
				'position'	=> $data['position'],
			];
		})->sortBy('position')->values()->toArray();

		$records = collect();

		foreach ($sports as $sport)
			if (!$records->has($sport['id']))
				$records->put($sport['id'], collect([
					'name'		=> $sport['name'],
					'value'		=> $sport['slug'],
					'current'	=> $this->isCurrent('sport', $sport['slug']),
				]));

		$collect->put('sports', collect([
			'param'		=> 'sport',
			'values'	=> 	$records->count() ? $records->values() : null,
		]));
	}

	/**
	 * собирает статусы
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 */

	private function collectStatus($collect, $filterout)
	{
		$matchstatuses = call_user_func(function () {
			$dataset	= $dataset = MatchesQuery::where('date', $this->get('day', now()->format('Y-m-d')))->get();
			$result		= collect();
			foreach ($dataset as $slug => $data)
				foreach ($data['tournaments'] as $tournament)
					if (!$this->get('sport', false) || $this->get('sport') == $slug)
						foreach ($tournament['matches'] as $match)
							if (!$result->filter(function ($row) use ($match) {
								return $row['id'] == $match['status_id'];
							})->count())
								$result->push([
									'id'	=> $match['status_id'],
									'name'	=> $match['status_name'],
									'slug'	=> $match['status_slug'],
								]);

			return $result;
		});
		$records = collect();

		foreach ($matchstatuses as $matchstatus)
			if (!$records->has($matchstatus['id']))
				$records->put($matchstatus['id'], collect([
					'name'		=> $matchstatus['name'],
					'value'		=> $matchstatus['slug'],
					'current'	=> $this->isCurrent('status', $matchstatus['slug']),
				]));

		$collect->put('statuses', collect([
			'param'		=> 'status',
			'values'	=> 	$records->count()
				? $records->sortBy(function ($param, $key) {
					return $param['name'];
				})->values()
				: null
			,
		]));
	}

	/**
	 * собирает турниры
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 */

	private function collectTournament($collect, $filterout)
	{
		$tournaments = call_user_func(function () {
			$dataset	= $dataset = MatchesQuery::where('date', $this->get('day', now()->format('Y-m-d')))->get();
			$result		= collect();
			foreach ($dataset as $slug => $data)
				foreach ($data['tournaments'] as $tournament_id => $tournament)
					if (
						$tournament['is_top'] == 1
						&& (!$this->get('sport', false) || $this->get('sport') == $slug)
					)
						$result->push([
							'id'		=> $tournament_id,
							'name'		=> $tournament['name'],
							'position'	=> $tournament['position'],
						]);

			return $result;
		});
		$records	= collect();

		foreach ($tournaments as $tournament)
			if (!$records->has($tournament['id']))
				$records->put($tournament['id'], collect([
					'name'		=> $tournament['name'],
					'value'		=> $tournament['id'],
					'position'	=> $tournament['position'],
					'current'	=> $this->isCurrent('tournament', $tournament['id']),
				]));

		$collect->put('tournaments', collect([
			'param'		=> 'tournament',
			'values'	=> 	$records->count()
				? $records->sortBy(function ($param, $key) {
					return $param['name'];
				})->values()
				: null
			,
		]));
	}
}
