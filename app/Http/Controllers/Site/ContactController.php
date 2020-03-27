<?php

namespace App\Http\Controllers\Site;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Crumb;

class ContactController extends Controller
{
	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('contacts')
			->first();

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection'
		));
	}
}
