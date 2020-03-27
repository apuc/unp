<?php

namespace App\Http\Controllers\Site;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Crumb;
use Carbon\Carbon;
use App\Http\Requests\Site\Brief\StoreRequest;
use Briefparameter;

class BriefController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('briefs')
			->first();

		// публикации
		Briefparameter::boot();

		$briefs['view'] = Briefparameter::get('v', 0);

		$query = \App\Brief::query()
			->select('briefs.*')
			->with([
				'user',
				'sport',
			])
			->withCount([
				'briefcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->whereHas('briefstatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
		;

		Briefparameter::filter($query);

		$briefs['rows'] = $query->sortBy(
				$briefs['sort'] = call_user_func(function () {
					switch(Briefparameter::get('s')) {
						case null:
						case 0:
						default:
							return 'posted_at';

						case 1:
							return 'briefcomments_count';
					}
				}),
				'desc'
			)
			->paginate($briefs['rc'] = call_user_func(function () {
				switch(Briefparameter::get('rc')) {
					case null:
						return config('interface.news');

					default:
						return Briefparameter::get('rc');
				}
			}))
		;

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'briefs'
		));
	}

	/**
	 *
	 *
	 */

	public function show($slug)
	{
		$sitesection = \App\Sitesection::query()
			->selectBySlug('briefs')
			->first();

		$brief = \App\Brief::query()
			->select('briefs.*')
			->with([
				'user',
				'sport',
				'briefcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				},
				'briefcomments.user',
			])
			->withCount([
				'briefcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->whereHas('briefstatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
			->where('id', \URI::asId($slug))
			->first();

		if (!filled($brief))
			abort(404);

		Crumb::set('name',				$brief->name);
		Crumb::set('seo_title',			$brief->seo_title ?? $sitesection->seo_title);
		Crumb::set('seo_description',	$brief->seo_description ?? trans('seo.site.brief', [
			'sport'			=> $brief->sport->name,
			'description'	=> $brief->announce ?? $brief->name,
		]));
		Crumb::set('seo_keywords',		$brief->seo_keywords ?? $sitesection->seo_keywords);
		Crumb::set('og_image',			asset('/preview/512/223/storage/briefs/' . $brief->picture));
		Crumb::set('og_image_width',	'512');
		Crumb::set('og_image_height',	'223');

		return view($this->view, compact(
			'brief'
		));
	}

	/**
	 *
	 *
	 */

	public function comment(StoreRequest $request)
	{
		$brief = \App\Brief::query()
			->select('briefs.*')
			->whereHas('briefstatus', function ($query) {
				$query->where('slug', 'confirmed');
			})
			->where('id', \URI::asId($request->brief))
			->first();

		$commentstatus = \App\Commentstatus::where('slug', 'new')->first();

		$briefcomment = new \App\Briefcomment;
		$briefcomment->brief_id			= $brief->id;
		$briefcomment->user_id			= Auth::user()->id;
		$briefcomment->commentstatus_id	= $commentstatus->id;
		$briefcomment->posted_at		= now();
		$briefcomment->message			= $request->message;
		$briefcomment->save();

		return redirect()->route('site.brief.show', ['brief' => \URI::asSlug($brief->id, $brief->name)]);
	}

	/**
	 *
	 *
	 *
	 */

	public function filter()
	{
		Briefparameter::boot(true);

		$answer = [[
			'parameter'	=> 'count',
			'value'		=> Briefparameter::get('count', 0),
		]];

		foreach (Briefparameter::topical() as $param => $dataset)
			if (!is_null($dataset))
				foreach ($dataset->get('values') as $value)
					$answer[] = [
						'parameter'	=> $param,
						'value'		=> $value['value'],
					];

		return response()->json($answer, 200);
	}
}
