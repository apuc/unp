<?php

namespace App\Queries\Site\Home;

use App\Queries\Query;

class ForecastsQuery extends Query
{
	public function run()
	{
		return \App\Forecast::query()
			->select('forecasts.*')
			->with([
				'team',
				'sport',
				'outcometype',
				'outcomescope',
				'outcomesubtype',
				'bookmaker',
				'user',
				'forecaststatus',
				'match.matchstatus',
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
//			->whereNotNull('forecasts.description')
			->orderBy('forecasts.posted_at', 'desc')
			->take(3)
			->get();
	}
}
