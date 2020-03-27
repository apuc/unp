<?php

namespace App\Http\Controllers\Site;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Legaldocument;
use Crumb;

class LegalController extends Controller
{
	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('legal')
			->first();

		// документы правовой информации
		$legaldocuments = Legaldocument::query()
			->selectRaw('legaldocuments.*, (SELECT MAX(issued_at) FROM legaleditions WHERE legaldocuments.id = legaleditions.legaldocument_id) issued_at')
			->orderBy('position', 'asc')
			->get()
			->reject(function ($legaldocument) {
				return $legaldocument->issued_at === null;
			})
		;

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'legaldocuments'
		));
	}

	public function show($document_slug)
	{
		$sitesection = \App\Sitesection::query()
			->selectBySlug('legal')
			->first();

		$legaldocument = Legaldocument::where('slug', $document_slug)->firstOrFail();

		$lastEdition = $legaldocument->legaleditions()
			->orderBy('issued_at', 'desc')
			->firstOrFail();

		$archiveEditions = $legaldocument->legaleditions()
			->orderBy('issued_at', 'desc')
			->get()
			->reject(function ($edition) use ($lastEdition){
				return $edition->id === $lastEdition->id;
		});

		$legaldocument->content		= $lastEdition->content;
		$legaldocument->issued_at 	= $lastEdition->issued_at;

		Crumb::set('name',				$legaldocument->name);
		Crumb::set('seo_title',			$legaldocument->seo_title ?? $sitesection->seo_title);
		Crumb::set('seo_description',	$legaldocument->seo_description ?? $sitesection->seo_description);
		Crumb::set('seo_keywords',		$legaldocument->seo_keywords ?? $sitesection->seo_keywords);

		$parameters['name'] = $legaldocument->name;

		return view(
			$this->view,
			compact(
				'legaldocument',
				'archiveEditions',
				'parameters'
			)
		);
	}
}
