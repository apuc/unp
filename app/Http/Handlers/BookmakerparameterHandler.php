<?php

namespace App\Http\Handlers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class BookmakerparameterHandler extends ParameterHandler
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
					$query->whereHas('deals.dealtype', function ($query) {
						$query->where('dealtypes.slug', $this->get('type'));
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
		$query = \App\Bookmaker::query()
			->selectRaw('count(`bookmakers`.`id`) as bookmakers_count')
			->where('bookmakers.is_enabled', 1)
		;

		if ($filterout)
			$this->filter($query);

		$this->set('count', $query->get()->first()->bookmakers_count);

		$params	= $this->collectParams($filterout);

		// алгоритм подгрузки существующих параметров
		$this->set('topical', new BookmakerparameterHandler($this->request));

		foreach ($params as $type => $row) {
			$value = new BookmakerparameterHandler($this->request);
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
		$query = \App\Bookmaker::query()
			->select([
				'dealtypes.id',
				'dealtypes.name',
				'dealtypes.slug',
			])
			->rightJoin('deals', 'deals.bookmaker_id', 'bookmakers.id')
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
}
