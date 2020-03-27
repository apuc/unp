<?php

namespace App\Http\Middleware\Site;

use Closure;
use Illuminate\Support\Facades\View;
use Auth;

class Forecasts
{
	/**
	 *
	 *
	 */

	public function handle($request, Closure $next)
	{
		$lastforecasts	= collect();
		$forecasts		= collect();

		if (!Auth::guest())
			$forecasts = \App\Forecast::query()
				->select('forecasts.*')
				->with([
					'team',
					'outcometype',
					'outcomescope',
					'outcomesubtype',
					'match.stage.season.tournament',
					'match.participants' => function ($query) {
						$query
							->orderBy('position', 'asc')
						;
					},
					'match.participants.team',
					'forecaststatus',
				])
				->where('forecasts.user_id', Auth::user()->id)
				->whereHas('match.participants', function ($query) {
					$query->skip(1)->take(1);
				})
				//->whereHas('forecaststatus', function ($query) {
				//	$query->whereNotIn('forecaststatuses.slug', ['checking', 'declined', 'cancelled', 'draft']);
				//})
				->orderBy('posted_at', 'desc')
				->take(3)
				->get();

		if ($forecasts->count())
			$forecasts->each(function ($forecast) use ($lastforecasts) {
				if (!$lastforecasts->has($forecast->match->started_at->format('d.m.Y H:i')))
					$lastforecasts->put($forecast->match->started_at->format('d.m.Y H:i'), collect());

				$lastforecasts->get($forecast->match->started_at->format('d.m.Y H:i'))->push([
					'type'				=> 'forecast',

					'id'				=> $forecast->id,
					'day'				=> $forecast->match->started_at->format('d.m.Y'),
					'time'				=> $forecast->match->started_at->format('H:i'),
					'team1'				=> $forecast->match->participants[0]->team->name,
					'team2'				=> $forecast->match->participants[1]->team->name,
					'status_slug'		=> $forecast->forecaststatus->slug,
					'status_name'		=> $forecast->forecaststatus->name,
					'rate'				=> $forecast->rate,
					'bet'				=> $forecast->bet,
					'tournament'		=> $forecast->match->stage->season->tournament->name,
					'stage'				=> $forecast->match->stage->name,
					'outcometype'		=> $forecast->outcometype->name,
					'outcomescope'		=> $forecast->outcomescope->name,
					'outcomesubtype'	=> parse($forecast->outcomesubtype->name, ['team' => optional($forecast->team)->name]),
				]);
			});

		View::share('lastforecasts', $lastforecasts);

		return $next($request);
	}
}
