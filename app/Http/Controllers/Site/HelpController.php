<?php

namespace App\Http\Controllers\Site;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Crumb;

class HelpController extends Controller
{
	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('help')
			->first();

		// разделы справки
		$helpsections = \App\Helpsection::query()
			->select('helpsections.*')
			->sortBy('name')
			->get();

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'helpsections'
		));
	}

	public function section($slug)
	{
		$sitesection = \App\Sitesection::query()
			->selectBySlug('help')
			->first();

		$helpsection = \App\Helpsection::query()
			->select('helpsections.*')
			->with([
				'helpquestions' => function ($query) {
					$query
						->where('is_enabled', true)
						->sortBy('name');
				},
			])
			->where('slug', $slug)
			->first();

		if (!filled($helpsection))
			abort(404);

		Crumb::set('name',				$helpsection->name);
		Crumb::set('seo_title',			$helpsection->seo_title ?? $sitesection->seo_title);
		Crumb::set('seo_description',	$helpsection->seo_description ?? $sitesection->seo_description);
		Crumb::set('seo_keywords',		$helpsection->seo_keywords ?? $sitesection->seo_keywords);
		Crumb::set('og_image',			asset('/preview/512/512/storage/helpsections/' . $helpsection->icon));
		Crumb::set('og_image_width',	'512');
		Crumb::set('og_image_height',	'512');

		return view($this->view, compact(
			'helpsection'
		));
	}

	public function ask()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('ask')
			->first();

		return view($this->view, compact(
			'sitesection'
		));
	}
}
