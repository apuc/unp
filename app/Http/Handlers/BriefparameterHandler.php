<?php

namespace App\Http\Handlers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BriefparameterHandler extends ParameterHandler
{
	/**
	 * применения фильтра на модели
	 *
	 * @param Builder $query
	 * @param array $ignore
	 */

	public function filter(Builder $query, array $ignore = [])
	{
		$query->where(function ($query) use ($ignore) {

			// если в игнор списке нет периода
			if (!in_array('day', $ignore)) {
				// фильтр по периоду
				if ($this->get('day', false) && $this->get('day') != now()->format('Y-m-d'))
					$query->where('briefs.posted_at', '<=', $this->get('day') . ' 23:59:59');
				else
					$query->where('briefs.posted_at', '<=', now()->toDateTimeString());
			}

			// если в игнор списке нет страны
			if (!in_array('country', $ignore))
				// фильтруем по стране
				if ($this->get('country', false) && !is_array($this->get('country')))
					$query->whereHas('tournaments', function ($query) {
						$query->whereHas('seasons', function ($query) {
							$query->whereHas('stages', function ($query) {
								$query->whereHas('country', function ($query) {
									$query->where('countries.slug', $this->get('country'));
								});
							});
						});
					});

			// если в игнор списке нет спорта
			if (!in_array('sport', $ignore))
				// фильтруем по спорту
				if ($this->get('sport', false) && !is_array($this->get('sport')))
					$query->whereHas('sport', function ($query) {
						$query->where('sports.slug', $this->get('sport'));
					});

			// если в игнор списке нет турнира
			if (!in_array('tournament', $ignore))
				// фильтруем по турниру
				if ($this->get('tournament', false) && !is_array($this->get('tournament')))
					$query->whereHas('tournaments', function ($query) {
						$query->where('tournaments.id', $this->get('tournament'));
					});
		});
	}

	/**
	 * подгрузчик параметров
	 *
	 * @param boolean $filterout
	 */

	public function boot($filterout = false)
	{
		$query = \App\Brief::query()
			->selectRaw('count(`briefs`.`id`) as briefs_count')
			->whereHas('briefstatus', function ($query) {
				$query->where('briefstatuses.slug', 'confirmed');
			})
		;

		if ($filterout)
			$this->filter($query);
		else
			$query->where('posted_at', '<=', Carbon::now()->toDateTimeString());

		$this->set('count', $query->get()->first()->briefs_count);

		$params	= $this->collectParams($filterout);

		// алгоритм подгрузки существующих параметров
		$this->set('topical', new BriefparameterHandler($this->request));

		foreach ($params as $type => $row) {
			$value = new BriefparameterHandler($this->request);
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

		// собираем турниры
		$this->collectTournament($collect, $filterout);

		// собираем страны
		$this->collectCountry($collect, $filterout);

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

		// предыдущие 14 дней
		for ($i = 14; $i >= 1; $i--) {
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
	}

	/**
	 * собирает спорт
	 *
	 * @param collect $collect
	 */

	private function collectSport($collect)
	{
		$query = \App\Brief::query()
			->select([
				'sports.id',
				'sports.name',
				'sports.slug',
			])
			->leftJoin('sports', 'briefs.sport_id', 'sports.id')
			->whereHas('briefstatus', function ($query) {
				$query->where('briefstatuses.slug', 'confirmed');
			})
			->orderBy('sports.position', 'asc')
		;

		$sports		= $query->get();
		$records	= collect();

		foreach ($sports as $sport)
			if (!$records->has($sport->id))
				$records->put($sport->id, collect([
					'name'		=> $sport->name,
					'value'		=> $sport->slug,
					'current'	=> $this->isCurrent('sport', $sport->slug),
				]));

		$collect->put('sports', collect([
			'param'		=> 'sport',
			'values'	=> 	$records->count() ? $records : null,
		]));
	}

	/**
	 * собирает страны
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 */

	private function collectCountry($collect, $filterout)
	{
		$query = \App\Brief::query()
			->select([
				'countries.id',
				'countries.name',
				'countries.slug',
			])
			->rightJoin('brieftournaments', 'briefs.id', 'brieftournaments.brief_id')
			->rightJoin('tournaments', 'brieftournaments.tournament_id', 'tournaments.id')
			->rightJoin('seasons', 'seasons.tournament_id', 'tournaments.id')
			->rightJoin('stages', 'stages.season_id', 'seasons.id')
			->rightJoin('countries', 'stages.country_id', 'countries.id')

			->whereHas('briefstatus', function ($query) {
				$query->where('briefstatuses.slug', 'confirmed');
			})
		;

		if ($filterout)
			$this->filter($query, [
				'country',
			]);

		$countries	= $query->get();
		$records	= collect();

		foreach ($countries as $country)
			if (!$records->has($country->id))
				$records->put($country->id, collect([
					'name'		=> $country->name,
					'value'		=> $country->slug,
					'current'	=> $this->isCurrent('country', $country->slug),
				]));

		$collect->put('countries', collect([
			'param'		=> 'country',
			'values'	=> 	$records->count()
				? $records->sortBy(function ($param, $key) {
					return $param['name'];
				})
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
		$query = \App\Brief::query()
			->select([
				'tournaments.id',
				'tournaments.name',
			])
			->rightJoin('brieftournaments', 'briefs.id', 'brieftournaments.brief_id')
			->rightJoin('tournaments', 'brieftournaments.tournament_id', 'tournaments.id')
			->where('tournaments.is_top', 1)
			->whereHas('briefstatus', function ($query) {
				$query->where('briefstatuses.slug', 'confirmed');
			})
		;

		if ($filterout)
			$this->filter($query, [
				'tournament',
			]);

		$tournaments	= $query->get();
		$records		= collect();

		foreach ($tournaments as $tournament)
			if (!$records->has($tournament->id))
				$records->put($tournament->id, collect([
					'name'		=> $tournament->name,
					'value'		=> $tournament->id,
					'current'	=> $this->isCurrent('tournament', $tournament->id),
				]));

		$collect->put('tournaments', collect([
			'param'		=> 'tournament',
			'values'	=> 	$records->count()
				? $records->sortBy(function ($param, $key) {
					return $param['name'];
				})
				: null
			,
		]));
	}
}
