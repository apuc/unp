<?php

namespace App\Http\Controllers\Site;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Crumb;
use DB;
use Matchparameter;
use Facades\App\Queries\Site\Match\OffersQuery;

class MatchController extends Controller
{

	/**
	 *
	 *
	 */

	public function index()
	{
		// тексты
		$sitesection = \App\Sitesection::query()
			->selectBySlug('matches')
			->first()
		;

		Matchparameter::boot();
		// центральные данные
		$dataset = Matchparameter::query();

		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	$sitesection->seo_description);
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'sitesection',
			'dataset'
		));
	}

	/**
	 *
	 *
	 */

	public function load()
	{
		return view($this->view);
	}

	/**
	 *
	 *
	 */

	public function show($id)
	{
		$sitesection = \App\Sitesection::query()
			->selectBySlug('matches')
			->first()
		;

		$match = \App\Match::query()
			->select('matches.*')
			->with([
				'stage.season.tournament.sport',
				'matchstatus',
				'participants' => function ($query) {
					$query->orderBy('position', 'asc');
				},
				'participants.team',
				'bookmaker1',
				'bookmakerx',
				'bookmaker2'
			])
			->whereHas('participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->findOrFail($id);

		// список прогнозов
		$forecasts = \App\Forecast::query()
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
					$query->orderBy('position', 'asc');
				},
				'match.participants.team',
			])
			->withCount([
				'forecastcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->whereHas('forecaststatus', function ($query) {
				$query->whereNotIn('forecaststatuses.slug', ['checking', 'declined', 'cancelled', 'draft']);
			})
			->whereHas('match.participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->where('forecasts.match_id', $id)
//			->whereNotNull('forecasts.description')
			->orderBy('forecasts.posted_at', 'desc')
			->get();

		Crumb::set('name', $match->participants[0]->team->name . ' - ' . $match->participants[1]->team->name);
		Crumb::set('seo_title',			$sitesection->seo_title);
		Crumb::set('seo_description',	trans('seo.site.match', [
			'team1'				=> $match->participants[0]->team->name,
			'team2'				=> $match->participants[1]->team->name,
			'tournament'		=> $match->stage->season->tournament->name,
			'season'			=> $match->stage->season->name,
			'day'				=> $match->started_at->format('d.m.Y'),
			'time'				=> $match->started_at->format('H:i'),
		]));
		Crumb::set('seo_keywords',		$sitesection->seo_keywords);

		return view($this->view, compact(
			'match',
			'forecasts'
		));
	}

	/**
	 *
	 *
	 */

	public function offer($id, Request $request)
	{
		$match = \App\Match::query()
			->select('matches.*')
			->with([
				'participants' => function ($query) {
					$query->orderBy('position', 'asc');
				},
				'participants.team',
				'bookmaker1',
				'bookmakerx',
				'bookmaker2',
				'stage.season.tournament.sport'
			])
			->whereHas('participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->findOrFail($id);

		$offers = OffersQuery::findOrFail($id);

		$type		= $request->type;
		$scope		= $request->scope;
		$bookmakers	= $offers[$type][$scope] ?? [];

		return view(call_user_func(function () use ($type) {
			$view = implode('.', array_slice(explode('.', $this->view), 0, -1));
			return "{$view}.{$type}";
		}), compact(
			'match',
			'bookmakers',
			'type',
			'scope'
		));
	}

	/**
	 *
	 *
	 */

	public function ajax()
	{
		Matchparameter::boot();
		// центральные данные
		$dataset = Matchparameter::query();

		return response()->json([
			'dataset'		=> $dataset,
			'parameters'	=> [
				'days'			=> !is_null(Matchparameter::topical('day'))			? Matchparameter::topical('day')		->getParameters()['values']->toArray() : [],
				'sports'		=> !is_null(Matchparameter::topical('sport'))		? Matchparameter::topical('sport')		->getParameters()['values']->toArray() : [],
				'statuses'		=> !is_null(Matchparameter::topical('status'))		? Matchparameter::topical('status')		->getParameters()['values']->toArray() : [],
				'tournaments'	=> !is_null(Matchparameter::topical('tournament'))	? Matchparameter::topical('tournament')	->getParameters()['values']->toArray() : [],
			],
			'options'		=> [
				'sport'			=> Matchparameter::get('sport',			false),
				'tournament'	=> Matchparameter::get('tournament',	false),
				'status'		=> Matchparameter::get('status',		false),
			],
		], 200);
	}
}
