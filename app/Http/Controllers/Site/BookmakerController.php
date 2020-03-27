<?php

namespace App\Http\Controllers\Site;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Bookmakerparameter;
use Crumb;

class BookmakerController extends Controller
{
	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('bookmakers')
			->first();

		// букмекеры
		Bookmakerparameter::boot();

		$bookmakers['view'] = Bookmakerparameter::get('v', 0);

		$query = \App\Bookmaker::query()
			->select('bookmakers.*')
			->where('is_enabled', 1)
		;

		Bookmakerparameter::filter($query);

		$bookmakers['rows'] = $query->sortBy(
				$bookmakers['sort'] = call_user_func(function () {
					switch(Bookmakerparameter::get('s')) {
						case null:
						case 0:
						default:
							return 'name';

						case 1:
							return 'bonus';
					}
				}),
				call_user_func(function () {
					switch(Bookmakerparameter::get('s')) {
						case null:
						case 0:
						default:
							return 'asc';

						case 1:
							return 'desc';
					}
				})
			)
			->paginate($bookmakers['rc'] = call_user_func(function () {
				switch(Bookmakerparameter::get('rc')) {
					case null:
						return config('interface.news');

					default:
						return Bookmakerparameter::get('rc');
				}
			}))
		;

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'bookmakers'
		));
	}

	public function show($slug)
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('bookmakers')
			->first();

		$bookmaker = \App\Bookmaker::query()
			->select('bookmakers.*')
			->with([
				'deals' => function ($query) {
					$query
						->with(['bookmaker'])
						->sortBy('started_at', 'desc');
				},
			])
			->where('is_enabled', 1)
			->where('slug', $slug)
			->first();

		if (!filled($bookmaker))
			abort(404);

		Crumb::set('name',				$bookmaker->name);
		Crumb::set('seo_title',			$bookmaker->seo_title ?? $sitesection->seo_title);
		Crumb::set('seo_description',	$bookmaker->seo_description ?? call_user_func(function () use ($bookmaker) {
			$dataset = collect();

			$dataset->push(trans('seo.site.bookmaker.name', [
				'name' => $bookmaker->name,
			]));

			if (null !== $bookmaker->bonus)
				$dataset->push(trans('seo.site.bookmaker.bonus', [
					'bonus' => $bookmaker->bonus,
				]));

			if (null !== $bookmaker->phone)
				$dataset->push(trans('seo.site.bookmaker.phone', [
					'phone' => $bookmaker->phone,
				]));

			if (null !== $bookmaker->email)
				$dataset->push(trans('seo.site.bookmaker.email', [
					'email' => $bookmaker->email,
				]));

			if (null !== $bookmaker->address)
				$dataset->push(trans('seo.site.bookmaker.address', [
					'address' => $bookmaker->address,
				]));

			return $dataset->implode(', ');
		}));
		Crumb::set('seo_keywords',		$bookmaker->seo_keywords ?? $sitesection->seo_keywords);
		Crumb::set('og_image',			asset('/preview/512/223/storage/bookmakers/' . $bookmaker->cover));
		Crumb::set('og_image_width',	'512');
		Crumb::set('og_image_height',	'223');

		return view($this->view, compact(
			'bookmaker'
		));
	}

	public function text()
	{
		Crumb::set('name',				'Мобильные приложения');

		return view($this->view);
	}
}
