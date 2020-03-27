<?php

namespace App\Http\Handlers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DealparameterHandler extends ParameterHandler
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

			// если в игнор списке нет типа
			if (!in_array('type', $ignore))
				// фильтр по типу
				if ($this->get('type', false) && !is_array($this->get('type', false)))
					$query->whereHas('dealtype', function ($query) {
						$query->where('dealtypes.slug', $this->get('type'));
					});

			// если в игнор списке нет букмекера
			if (!in_array('bookmaker', $ignore))
				// фильтр по букмекеру
				if ($this->get('bookmaker', false) && !is_array($this->get('bookmaker', false)))
					$query->whereHas('bookmaker', function ($query) {
						$query->where('bookmakers.slug', $this->get('bookmaker'));
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
		$query = \App\Deal::query()
			->selectRaw('count(`deals`.`id`) as deals_count')
		;

		if ($filterout)
			$this->filter($query);

		$this->set('count', $query->get()->first()->deals_count);

		$params	= $this->collectParams($filterout);

		// алгоритм подгрузки существующих параметров
		$this->set('topical', new DealparameterHandler($this->request));

		foreach ($params as $type => $row) {
			$value = new DealparameterHandler($this->request);
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

		// собираем типы
		$this->collectTypes($collect, $filterout);

		// собираем букмекеров
		$this->collectBookmakers($collect, $filterout);

		return $collect;
	}

	/**
	 * собирает типы
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 */

	private function collectTypes($collect, $filterout)
	{
		$query = \App\Deal::query()
			->select([
				'dealtypes.id',
				'dealtypes.name',
				'dealtypes.slug',
			])
			->rightJoin('dealtypes', 'deals.dealtype_id', 'deals.id')
			->whereNotNull('deals.id')
			->groupBy('dealtypes.id')
		;

		if ($filterout)
			$this->filter($query, [
				'type',
			]);

		$dealtypes	= $query->get();
		$records	= collect();

		foreach ($dealtypes as $dealtype)
			if (!$records->has($dealtype->id))
				$records->put($dealtype->id, collect([
					'name'		=> $dealtype->name,
					'value'		=> $dealtype->slug,
					'current'	=> $this->isCurrent('type', $dealtype->slug),
				]));

		$collect->put('types', collect([
			'param'		=> 'type',
			'values'	=> 	$records->count()
				? $records->sortBy(function ($param, $key) {
					return $param['name'];
				})
				: null
			,
		]));
	}

	/**
	 * собирает букмекеров
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 */

	private function collectBookmakers($collect, $filterout)
	{
		$query = \App\Deal::query()
			->select([
				'bookmakers.id',
				'bookmakers.name',
				'bookmakers.slug',
			])
			->rightJoin('bookmakers', 'deals.bookmaker_id', 'bookmakers.id')
			->whereNotNull('deals.id')
			->groupBy('bookmakers.id')
		;

		if ($filterout)
			$this->filter($query, [
				'bookmaker',
			]);

		$bookmakers	= $query->get();
		$records	= collect();

		foreach ($bookmakers as $bookmaker)
			if (!$records->has($bookmaker->id))
				$records->put($bookmaker->id, collect([
					'name'		=> $bookmaker->name,
					'value'		=> $bookmaker->slug,
					'current'	=> $this->isCurrent('bookmaker', $bookmaker->slug),
				]));

		$collect->put('bookmakers', collect([
			'param'		=> 'bookmaker',
			'values'	=> 	$records->count()
				? $records->sortBy(function ($param, $key) {
					return $param['name'];
				})
				: null
			,
		]));
	}
}
