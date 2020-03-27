<?php

namespace App\Http\Handlers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostparameterHandler extends ParameterHandler
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
					$query->where('posts.posted_at', '<=', $this->get('day') . ' 23:59:59');
				else
					$query->where('posts.posted_at', '<=', Carbon::now()->toDateTimeString());
			}

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

			// если в игнор списке нет тега
			if (!in_array('tag', $ignore))
				// фильтруем по тегу
				if ($this->get('tag', false) && !is_array($this->get('tag')))
					$query->whereHas('tags', function ($query) {
						$query->where('tags.id', $this->get('tag'));
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
		$query = \App\Post::query()
			->selectRaw('count(`posts`.`id`) as posts_count')
			->whereHas('poststatus', function ($query) {
				$query->where('poststatuses.slug', 'confirmed');
			})
		;

		if ($filterout)
			$this->filter($query);
		else
			$query->where('posted_at', '<=', Carbon::now()->toDateTimeString());

		$this->set('count', $query->get()->first()->posts_count);

		$params	= $this->collectParams($filterout);

		// алгоритм подгрузки существующих параметров
		$this->set('topical', new PostparameterHandler($this->request));

		foreach ($params as $type => $row) {
			$value = new PostparameterHandler($this->request);
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

		// собираем теги
		$this->collectTag($collect, $filterout);

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
		$query = \App\Post::query()
			->select([
				'sports.id',
				'sports.name',
				'sports.slug',
			])
			->leftJoin('sports', 'posts.sport_id', 'sports.id')
			->whereHas('poststatus', function ($query) {
				$query->where('poststatuses.slug', 'confirmed');
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
	 * собирает турниры
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 */

	private function collectTournament($collect, $filterout)
	{
		$query = \App\Post::query()
			->select([
				'tournaments.id',
				'tournaments.name',
			])
			->rightJoin('posttournaments', 'posts.id', 'posttournaments.post_id')
			->rightJoin('tournaments', 'posttournaments.tournament_id', 'tournaments.id')
			->where('tournaments.is_top', 1)
			->whereHas('poststatus', function ($query) {
				$query->where('poststatuses.slug', 'confirmed');
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

	/**
	 * собирает теги
	 *
	 * @param collect $collect
	 * @param boolean $filterout
	 */

	private function collectTag($collect, $filterout)
	{
		$query = \App\Post::query()
			->select([
				'tags.id',
				'tags.name',
			])
			->rightJoin('posttags', 'posts.id', 'posttags.post_id')
			->rightJoin('tags', 'posttags.tag_id', 'tags.id')

			->whereHas('poststatus', function ($query) {
				$query->where('poststatuses.slug', 'confirmed');
			})
		;

		if ($filterout)
			$this->filter($query, [
				'tag',
			]);

		$tags		= $query->get();
		$records	= collect();

		foreach ($tags as $tag)
			if (!$records->has($tag->id))
				$records->put($tag->id, collect([
					'name'		=> $tag->name,
					'value'		=> $tag->id,
					'current'	=> $this->isCurrent('tag', $tag->id),
				]));

		$collect->put('tags', collect([
			'param'		=> 'tag',
			'values'	=> 	$records->count()
				? $records->sortBy(function ($param, $key) {
					return $param['name'];
				})
				: null
			,
		]));
	}
}
