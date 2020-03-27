<?php

namespace App\Http\Controllers\Site;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Crumb;
use Forecastparameter;
use App\Http\Requests\Site\Forecast\StoreRequest;

class ForecastController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('forecasts')
			->first();

		// прогнозы
		Forecastparameter::boot();

		$forecasts['view'] = Forecastparameter::get('v', 0);

		$query = \App\Forecast::query()
			->select('forecasts.*')
			->with([
				'sport',
				'outcometype',
				'outcomescope',
				'outcomesubtype',
				'bookmaker',
				'user',
				'forecaststatus',
				'team',
				'match.stage.season.tournament',
				'match.participants' => function ($query) {
					$query
						->orderBy('position', 'asc')
					;
				},
				'match.participants.team',
				'match.matchstatus',
			])
			->withCount([
				'forecastcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->leftJoin('matches', 'forecasts.match_id', '=', 'matches.id')
			->whereHas('forecaststatus', function ($query) {
				$query->whereNotIn('forecaststatuses.slug', ['checking', 'declined', 'cancelled', 'draft']);
			})
			->whereHas('match.participants', function ($query) {
				$query->skip(1)->take(1);
			})
//			->whereNotNull('forecasts.description')
		;

		Forecastparameter::filter($query);

		$forecasts['rows'] = $query->orderBy(
				$forecasts['sort'] = call_user_func(function () {
					switch(Forecastparameter::get('s')) {
						case null:
						case 0:
						default:
							return 'matches.started_at';

						case 1:
							return 'forecastcomments_count';
					}
				}),
				'desc'
			)
			->paginate($forecasts['rc'] = call_user_func(function () {
				switch(Forecastparameter::get('rc')) {
					case null:
						return config('interface.forecasts');

					default:
						return Forecastparameter::get('rc');
				}
			}))
		;

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'forecasts'
		));
	}

	/**
	 *
	 *
	 */

	public function show($id)
	{
		$sitesection = \App\Sitesection::query()
			->selectBySlug('forecasts')
			->first();

		$forecast = \App\Forecast::query()
			->select('forecasts.*')
			->with([
				'sport',
				'outcometype',
				'outcomescope',
				'outcomesubtype',
				'bookmaker',
				'user',
				'team',
				'forecaststatus',
				'match.stage.season.tournament',
				'match.participants' => function ($query) {
					$query
						->orderBy('position', 'asc')
					;
				},
				'match.participants.team',
				'forecastcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				},
				'forecastcomments.user',
				'match.matchstatus',
			])
			->withCount([
				'forecastcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->leftJoin('matches', 'forecasts.match_id', '=', 'matches.id')
			->whereHas('forecaststatus', function ($query) {
				$query->whereNotIn('forecaststatuses.slug', ['checking', 'declined', 'cancelled', 'draft']);
			})
			->whereHas('match.participants', function ($query) {
				$query->skip(1)->take(1);
			})
//			->whereNotNull('forecasts.description')
			->findOrFail($id)
		;

		Crumb::set('name', $forecast->match->participants[0]->team->name . ' - ' . $forecast->match->participants[1]->team->name);
		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	trans('seo.site.forecast', [
			'team1'				=> $forecast->match->participants[0]->team->name,
			'team2'				=> $forecast->match->participants[1]->team->name,
			'tournament'		=> $forecast->match->stage->season->tournament->name,
			'season'			=> $forecast->match->stage->season->name,
			'outcometype'		=> $forecast->outcometype->name,
			'outcomescope'		=> $forecast->outcomescope->name,
			'outcomesubtype'	=> parse($forecast->outcomesubtype->name, ['team' => optional($forecast->team)->name]),
			'bet'				=> $forecast->bet,
			'rate'				=> $forecast->rate,
			'bookmaker'			=> $forecast->bookmaker->name,
		]));
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);
		Crumb::set('og_image',			asset('/preview/164/120/storage/bookmakers/' . $forecast->bookmaker->logo));
		Crumb::set('og_image_width',	'164');
		Crumb::set('og_image_height',	'120');

		return view($this->view, compact(
			'forecast'
		));
	}

	/**
	 *
	 *
	 */

	public function comment(StoreRequest $request)
	{
		$forecast = \App\Forecast::query()
			->select('forecasts.*')
			->whereHas('forecaststatus', function ($query) {
				$query->whereNotIn('forecaststatuses.slug', ['checking', 'declined', 'cancelled', 'draft']);
			})
			->findOrFail($request->forecast)
		;

		$commentstatus = \App\Commentstatus::where('slug', 'new')->first();

		$forecastcomment = new \App\Forecastcomment;
		$forecastcomment->forecast_id		= $forecast->id;
		$forecastcomment->user_id			= Auth::user()->id;
		$forecastcomment->commentstatus_id	= $commentstatus->id;
		$forecastcomment->posted_at			= now();
		$forecastcomment->message			= $request->message;
		$forecastcomment->save();

		return redirect()->route('site.forecast.show', ['forecast' => $forecast->id]);
	}

	/**
	 *
	 *
	 */

	public function filter()
	{
		Forecastparameter::boot(true);

		$answer = [[
			'parameter'	=> 'count',
			'value'		=> Forecastparameter::get('count', 0),
		]];

		foreach (Forecastparameter::topical() as $param => $dataset)
			if (!is_null($dataset))
				foreach ($dataset->get('values') as $value)
					$answer[] = [
						'parameter'	=> $param,
						'value'		=> $value['value'],
					];

		return response()->json($answer, 200);
	}
}
