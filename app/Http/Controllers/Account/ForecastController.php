<?php

namespace App\Http\Controllers\Account;

use Auth;
use Crumb;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Forecastparameter;
use App\Http\Requests\Account\Forecast\StoreRequest;

use Facades\App\Queries\Site\Match\MatchesQuery;
use Facades\App\Queries\Site\Match\OffersQuery;

class ForecastController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		// прогнозы
		Forecastparameter::boot(false, false);

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
				'team',
				'forecaststatus',
				'match.stage.country',
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
			->whereHas('match.participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->where('forecasts.user_id', Auth::user()->id)
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
			->get()
		;

		return view($this->view, compact(
			'forecasts'
		));
	}

	/**
	 *
	 *
	 */

	public function create()
	{
		$forecast = new \App\Forecast;

		return view($this->view, compact(
			'forecast'
		));
	}

	/**
	 *
	 *
	 */

	public function store(StoreRequest $request)
	{
//		if (is_null($request->description))
			$forecaststatus = \App\Forecaststatus::where('slug', 'confirmed')->first();

//		else
//			$forecaststatus = \App\Forecaststatus::where('slug', 'checking')->first();

		$forecast = new \App\Forecast;
		$forecast->sport_id				= $request->sport_id;
		$forecast->outcome_id			= $request->outcome_id;
		$forecast->outcometype_id		= $request->outcometype_id;
		$forecast->outcomescope_id		= $request->outcomescope_id;
		$forecast->outcomesubtype_id	= $request->outcomesubtype_id;
		$forecast->team_id				= $request->team_id;
		$forecast->bookmaker_id			= $request->bookmaker_id;
		$forecast->match_id				= $request->match_id;
		$forecast->user_id				= $request->user_id;
		$forecast->forecaststatus_id	= $forecaststatus->id;
		$forecast->rate					= $request->rate;
		$forecast->bet					= $request->bet;
		$forecast->posted_at			= now();
		$forecast->description			= $request->description;
		$forecast->save();

		return response()->json([
			'status'	=> 'success',
			'redirect'	=> route('account.forecast.show', [
				'forecast_id' => $forecast->id,
			]),
		], 200);
	}

	/**
	 *
	 *
	 */

	public function show($id)
	{
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
				'match.matchstatus',
			])
			->withCount([
				'forecastcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->where('forecasts.user_id', Auth::user()->id)
			->whereHas('match.participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->findOrFail($id)
		;

		Crumb::set('name', $forecast->match->participants[0]->team->name . ' - ' . $forecast->match->participants[1]->team->name);

		return view($this->view, compact(
			'forecast'
		));
	}

	/**
	 *
	 *
	 */

	public function sports(Request $request)
	{
		$sports		= collect();
		$dataset	= MatchesQuery::getAll();

		foreach ($dataset as $data)
			$sports->push([
				'id'	=> $data['id'],
				'name'	=> $data['name'],
			]);

		$sport_id = $request->sport_id;

		return view($this->view, compact(
			'sports',
			'sport_id'
		));
	}

	/**
	 *
	 *
	 */

	public function tournaments(Request $request)
	{
		$tournaments	= collect();
		$dataset		= MatchesQuery::getAll();

		foreach ($dataset as $data)
			if ($data['id'] == $request->sport_id)
				foreach ($data['tournaments'] as $tournament_id => $tournament)
					$tournaments->push([
						'id'	=> $tournament_id,
						'name'	=> $tournament['name'],
					]);

		if (!($tournaments = $tournaments->sortBy('name'))->count())
			abort(404);

		$tournament_id = $request->tournament_id;

		return view($this->view, compact(
			'tournaments',
			'tournament_id'
		));
	}

	/**
	 *
	 *
	 */

	public function matches(Request $request)
	{
		$matches	= collect();
		$dataset	= MatchesQuery::getAll();

		foreach ($dataset as $data)
			if (isset($data['tournaments'][$request->tournament_id]))
				foreach ($data['tournaments'][$request->tournament_id]['matches'] as $match_id => $match)
					$matches->push([
						'id'			=> $match_id,
						'team1_name'	=> $match['team1_name'],
						'team2_name'	=> $match['team2_name'],
					]);

		if (!($matches = $matches->sortBy('team1_name'))->count())
			abort(404);

		$match_id = $request->match_id;

		return view($this->view, compact(
			'matches',
			'match_id'
		));
	}

	/**
	 *
	 *
	 */

	public function offers(Request $request)
	{
		// проверяем матч
		$match = \App\Match::query()
			->select('matches.*')
			->whereHas('participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->where('matches.started_at', '>', now()->addMinutes(config('forecast.time')))
			->findOrFail($request->match_id)
		;

		$offer_id = $request->offer_id;

		return view($this->view, compact(
			'offer_id'
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
					$query
						->orderBy('position', 'asc')
					;
				},
				'participants.team',
				'bookmaker1',
				'bookmakerx',
				'bookmaker2'
			])
			->whereHas('participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->findOrFail($id)
		;

		$offers = OffersQuery::findOrFail($id);

		$type		= $request->type;
		$scope		= $request->scope;
		$bookmakers	= $offers[$type][$scope] ?? [];

		return view(call_user_func(function () use ($request, $type) {
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

	public function filter()
	{
		Forecastparameter::boot(true, false);

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
