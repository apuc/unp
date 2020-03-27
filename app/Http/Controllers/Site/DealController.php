<?php

namespace App\Http\Controllers\Site;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Facades\App\Queries\Site\Home\Texts;
use Dealparameter;
use Crumb;

class DealController extends Controller
{
	public function index()
	{
//		debug(Texts::expire(30)->where('z', 1)->where('id', 10)->where('a', 123)->where('slug', 'shit')->get());

		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('deals')
			->first();

		// акции
		Dealparameter::boot();

		$deals['view'] = Dealparameter::get('v', 0);

		$query = \App\Deal::query()
			->select('deals.*')
			->with([
				'bookmaker',
			])
		;

		Dealparameter::filter($query);

		$deals['rows'] = $query->sortBy(
				$deals['sort'] = call_user_func(function () {
					switch(Dealparameter::get('s')) {
						case null:
						case 0:
						default:
							return 'name';

						case 1:
							return 'started_at';
					}
				}),
				call_user_func(function () {
					switch(Dealparameter::get('s')) {
						case null:
						case 0:
						default:
							return 'asc';

						case 1:
							return 'desc';
					}
				})
			)
			->paginate($deals['rc'] = call_user_func(function () {
				switch(Dealparameter::get('rc')) {
					case null:
						return config('interface.news');

					default:
						return Dealparameter::get('rc');
				}
			}))
		;

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'deals'
		));
	}

	public function show($id)
	{
		$sitesection = \App\Sitesection::query()
			->selectBySlug('deals')
			->first();

		$deal = \App\Deal::query()
			->select('deals.*')
			->with([
				'bookmaker',
				'dealtype',
			])
			->findOrFail($id);

		Crumb::set('name',				$deal->name);
		Crumb::set('seo_title',			$deal->seo_title ?? $sitesection->seo_title);
		Crumb::set('seo_description',	$deal->seo_description ?? call_user_func(function () use ($deal) {
			$dataset = collect();

			$dataset->push(trans('seo.site.deal.name', [
				'name'		=> $deal->name,
				'bookmaker'	=> $deal->bookmaker->name,
				'dealtype'	=> $deal->dealtype->name,
			]));

			if (null !== $deal->started_at || null !== $deal->finished_at)
				$dataset->push(trans('seo.site.deal.period.name'));

			if (null !== $deal->started_at)
				$dataset->push(trans('seo.site.deal.period.started_at', [
					'started_at' => $deal->started_at->format('d.m.Y'),
				]));

			if (null !== $deal->started_at)
				$dataset->push(trans('seo.site.deal.period.finished_at', [
					'finished_at' => $deal->finished_at->format('d.m.Y'),
				]));

			return $dataset->implode(' ');
		}));
		Crumb::set('seo_keywords',		$deal->seo_keywords ?? $sitesection->seo_keywords);
		Crumb::set('og_image',			asset('/preview/512/223/storage/deals/' . $deal->cover));
		Crumb::set('og_image_width',	'512');
		Crumb::set('og_image_height',	'223');

		$deals = \App\Deal::query()
			->select('deals.*')
			->with([
				'bookmaker',
			])
			->whereNotIn('id', [ $id ])
			->where('bookmaker_id', $deal->bookmaker_id)
			->sortBy('started_at', 'desc')
			->get();

		return view($this->view, compact(
			'deal',
			'deals'
		));

	}

	/**
	 *
	 *
	 */

	public function filter()
	{
		Dealparameter::boot(true);

		$answer = [[
			'parameter'	=> 'count',
			'value'		=> Dealparameter::get('count', 0),
		]];

		foreach (Dealparameter::topical() as $param => $dataset)
			if (!is_null($dataset))
				foreach ($dataset->get('values') as $value)
					$answer[] = [
						'parameter'	=> $param,
						'value'		=> $value['value'],
					];

		return response()->json($answer, 200);
	}
}
