<?php

namespace App\Http\Handlers;

use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ForecastparameterHandler extends ParameterHandler
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
					$query->whereHas('match', function ($query) {
						$query->where('matches.started_at', '<=', $this->get('day') . ' 23:59:59');
					});
				else
					$query->whereHas('match', function ($query) {
						$query->where('matches.started_at', '<=', now()->toDateString() . ' 23:59:59');
					});
			}

			// если в игнор списке нет спорта
			if (!in_array('sport', $ignore)) {
				// фильтруем по спорту
				if ($this->get('sport', false) && !is_array($this->get('sport'))) {
					$query->whereHas('match.stage.season.tournament.sport', function ($query) {
						$query->where('sports.slug', $this->get('sport'));
					});
				}
				else {
					$query->whereHas('match.stage.season.tournament.sport', function ($query) {
						$query->where('sports.has_odds', 1);
					});
				}
			}

			// если в игнор списке нет турнира
			if (!in_array('tournament', $ignore))
				// фильтруем по турниру
				if ($this->get('tournament', false) && !is_array($this->get('tournament')))
					$query->whereHas('match.stage.season.tournament', function ($query) {
						$query->where('tournaments.id', $this->get('tournament'));
					});

			// если в игнор списке нет статуса
			if (!in_array('status', $ignore))
				// фильтруем по статусу
				if ($this->get('status', false) && !is_array($this->get('status'))) {
					$query->whereHas('forecaststatus', function ($query) {
						$query->where('forecaststatuses.slug', $this->get('status'));
					});
				}

			// если в игнор списке нет каппера
			if (!in_array('capper', $ignore))
				// фильтруем по капперу
				if ($this->get('capper', false) && !is_array($this->get('capper'))) {
					$query->whereHas('user', function ($query) {
						$query->where('login', $this->get('capper'));
					});
				}
		});
	}

	/**
	 * подгрузчик параметров
	 *
	 * @param boolean $filterout
	 */

	public function boot($filterout = false, $site = true)
	{
		$query = \App\Forecast::query()
			->selectRaw('count(`forecasts`.`id`) as forecasts_count')
			->whereHas('forecaststatus', function ($query) {
				$query->whereNotIn('forecaststatuses.slug', ['checking', 'declined', 'cancelled', 'draft']);
			})
		;

		if ($site)
			$query->whereNotNull('forecasts.description');
		else
			$query->where('forecasts.user_id', Auth::user()->id);

		if ($filterout)
			$this->filter($query);

		else
			$query
				->whereHas('match', function ($query) {
					$query->where('matches.started_at', '<=', now()->toDateString() . ' 23:59:59');
				})
				->whereHas('match.stage.season.tournament.sport', function ($query) {
					$query->where('sports.has_odds', 1);
				})
			;

		$this->set('count', $query->get()->first()->forecasts_count);

		$params	= $this->collectParams($filterout, $site);

		// алгоритм подгрузки существующих параметров
		$this->set('topical', new ForecastparameterHandler($this->request));

		foreach ($params as $type => $row) {
			$value = new ForecastparameterHandler($this->request);
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
	 * @param boolean $site
	 */

	private function collectParams($filterout, $site)
	{
		$collect = collect();

		// собираем дни
		$this->collectDay($collect);

		// собираем спорт
		$this->collectSport($collect, $site);

		// собираем турниры
		$this->collectTournament($collect, $filterout, $site);

		// собираем статусы
		$this->collectStatus($collect, $filterout, $site);

		// собираем капперов
		$this->collectCapper($collect, $filterout, $site);

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
	 * @param boolean $site
	 */

	private function collectSport($collect, $site)
	{
		$query = \App\Sport::query()
			->select([
				'sports.id',
				'sports.name',
				'sports.slug',
			])
			->leftJoin('tournaments',	'tournaments.sport_id',		'=', 'sports.id')
			->leftJoin('seasons',		'seasons.tournament_id',	'=', 'tournaments.id')
			->leftJoin('stages',		'stages.season_id',			'=', 'seasons.id')
			->leftJoin('matches',		'matches.stage_id',			'=', 'stages.id')
			->leftJoin('forecasts',		'forecasts.match_id',		'=', 'matches.id')
			->whereNotNull('forecasts.id')
		;

		if ($site)
			$query->whereNotNull('forecasts.description');
		else
			$query->where('forecasts.user_id', Auth::user()->id);

		$sports = $query
			->where('sports.has_odds', 1)
			->groupBy('sports.id')
			->orderBy('sports.position', 'asc')
			->get()
		;
		$records = collect();

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
	 * собирает статусы
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 * @param boolean $site
	 */

	private function collectStatus($collect, $filterout, $site)
	{
		$query = \App\Forecast::query()
			->select([
				'forecaststatuses.id',
				'forecaststatuses.name',
				'forecaststatuses.slug',
			])
			->leftJoin('forecaststatuses', 'forecasts.forecaststatus_id', 'forecaststatuses.id')
		;

		if ($site)
			$query->whereNotNull('forecasts.description');
		else
			$query->where('forecasts.user_id', Auth::user()->id);

		if ($filterout)
			$this->filter($query, [
				'status',
			]);

		$forecaststatuses	= $query->groupBy('forecaststatuses.id')->get();
		$records			= collect();

		foreach ($forecaststatuses as $forecaststatus)
			if (!$records->has($forecaststatus->id))
				$records->put($forecaststatus->id, collect([
					'name'		=> $forecaststatus->name,
					'value'		=> $forecaststatus->slug,
					'current'	=> $this->isCurrent('status', $forecaststatus->slug),
				]));

		$collect->put('statuses', collect([
			'param'		=> 'status',
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
	 * @param boolean $site
	 */

	private function collectTournament($collect, $filterout, $site)
	{
		$query = \App\Forecast::query()
			->select([
				'tournaments.id',
				'tournaments.name',
				'tournaments.position',
			])
			->rightJoin('matches', 'forecasts.match_id', 'matches.id')
			->rightJoin('stages', 'matches.stage_id', 'stages.id')
			->rightJoin('seasons', 'stages.season_id', 'seasons.id')
			->rightJoin('tournaments', 'seasons.tournament_id', 'tournaments.id')
			->rightJoin('sports', 'tournaments.sport_id', 'sports.id')
			->where('tournaments.is_top', 1)
			->where('sports.has_odds', 1)
			->whereNotNull('forecasts.id')
		;

		if ($site)
			$query->whereNotNull('forecasts.description');
		else
			$query->where('forecasts.user_id', Auth::user()->id);

		if ($filterout)
			$this->filter($query, [
				'tournament',
			]);

		$tournaments	= $query->groupBy('tournaments.id')->get();
		$records		= collect();

		foreach ($tournaments as $tournament)
			if (!$records->has($tournament->id))
				$records->put($tournament->id, collect([
					'name'		=> $tournament->name,
					'value'		=> $tournament->id,
					'position'	=> $tournament->position,
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

	/**
	 * собирает капперов
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 * @param boolean $site
	 */

	private function collectCapper($collect, $filterout, $site)
	{
		$query = \App\Forecast::query()
			->select([
				'users.id',
				'users.name',
				'users.login',
			])
			->leftJoin('users', 'forecasts.user_id', 'users.id')
		;

		if ($site)
			$query->whereNotNull('forecasts.description');
		else
			$query->where('forecasts.user_id', Auth::user()->id);

		if ($filterout)
			$this->filter($query, [
				'capper',
			]);

		$cappers = $query->groupBy('users.id')->get();
		$records = collect();

		foreach ($cappers as $capper)
			if (!$records->has($capper->id))
				$records->put($capper->id, collect([
					'name'		=> $capper->name ?? $capper->login,
					'value'		=> $capper->login,
					'current'	=> $this->isCurrent('capper', $capper->login),
				]));

		$collect->put('cappers', collect([
			'param'		=> 'capper',
			'values'	=> 	$records->count()
				? $records->sortBy(function ($param, $key) {
					return $param['name'];
				})
				: null
			,
		]));
	}
}
