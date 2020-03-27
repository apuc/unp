<?php

namespace App\Http\Middleware\Office\Filters;

use Closure;
use Illuminate\Support\Facades\View;
use App\Forecaststatus;
use App\User;
use App\Sport;
use App\Tournament;
use App\Season;
use App\Stage;
use App\Match;
use App\Outcometype;
use App\Outcomesubtype;
use App\Outcomescope;
use App\Bookmaker;
use Carbon\Carbon;

class Forecast
{
	/**
	 *
	 * @param \Illuminate\Http\Request $request
	 * @param \Closure $next
	 * @return mixed
	 */

	public function handle($request, Closure $next)
	{
		View::share([
			'id'			=> $request->f_id ?? null,
			'posted_at'		=> $request->f_posted_at ? [
				!empty($request->f_posted_at[0]) ? Carbon::parse($request->f_posted_at[0]) : null,
				!empty($request->f_posted_at[1]) ? Carbon::parse($request->f_posted_at[1]) : null,
			] : [null, null],
			'forecaststatus'	=> [
				'id'		=> $request->f_forecaststatus_id ?? null,
				'record'	=> !empty($request->f_forecaststatus_id) ? Forecaststatus::find($request->f_forecaststatus_id) : null,
			],
			'user'	=> [
				'id'		=> $request->f_user_id ?? null,
				'record'	=> !empty($request->f_user_id) ? User::find($request->f_user_id) : null,
			],
			'sport'	=> [
				'id'		=> $request->f_sport_id ?? null,
				'record'	=> !empty($request->f_sport_id) ? Sport::find($request->f_sport_id) : null,
			],
			'tournament'	=> [
				'id'		=> $request->f_tournament_id ?? null,
				'record'	=> !empty($request->f_tournament_id) ? Tournament::find($request->f_tournament_id) : null,
			],
			'season'	=> [
				'id'		=> $request->f_season_id ?? null,
				'record'	=> !empty($request->f_season_id) ? Season::find($request->f_season_id) : null,
			],
			'stage'	=> [
				'id'		=> $request->f_stage_id ?? null,
				'record'	=> !empty($request->f_stage_id) ? Stage::find($request->f_stage_id) : null,
			],
			'match'	=> [
				'id'		=> $request->f_match_id ?? null,
				'record'	=> !empty($request->f_match_id) ? Match::find($request->f_match_id) : null,
			],
			'started_at'	=> $request->f_started_at ? [
				!empty($request->f_started_at[0]) ? Carbon::parse($request->f_started_at[0]) : null,
				!empty($request->f_started_at[1]) ? Carbon::parse($request->f_started_at[1]) : null,
			] : [null, null],
			'outcometype'	=> [
				'id'		=> $request->f_outcometype_id ?? null,
				'record'	=> !empty($request->f_outcometype_id) ? Outcometype::find($request->f_outcometype_id) : null,
			],
			'outcomesubtype'	=> [
				'id'		=> $request->f_outcomesubtype_id ?? null,
				'record'	=> !empty($request->f_outcomesubtype_id) ? Outcomesubtype::find($request->f_outcomesubtype_id) : null,
			],
			'outcomescope'	=> [
				'id'		=> $request->f_outcomescope_id ?? null,
				'record'	=> !empty($request->f_outcomescope_id) ? Outcomescope::find($request->f_outcomescope_id) : null,
			],
			'bookmaker'	=> [
				'id'		=> $request->f_bookmaker_id ?? null,
				'record'	=> !empty($request->f_bookmaker_id) ? Bookmaker::find($request->f_bookmaker_id) : null,
			],
			'rate'			=> $request->f_rate ?? null,
			'bet'			=> $request->f_bet ?? null,
		]);

		return $next($request);
	}
}
