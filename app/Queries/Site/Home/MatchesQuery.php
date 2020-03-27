<?php

namespace App\Queries\Site\Home;

use App\Queries\Query;

class MatchesQuery extends Query
{
	public function run()
	{
		return \App\Match::query()
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
			->whereHas('stage.season.tournament', function ($query) {
				$query->where('tournaments.is_top', 1);
			})
			->whereHas('stage.season.tournament.sport', function ($query) {
				$query->where('sports.has_odds', 1);
			})
			->whereHas('matchstatus', function ($query) {
				$query->whereNotIn('matchstatuses.slug', ['finished', 'unknown', 'cancelled', 'interrupted', 'deleted']);
			})
			->whereHas('participants', function ($query) {
				$query->skip(1)->take(1);
			})
			->where('matches.started_at', '>=', now()->toDateString() . ' 00:00:00')
			->take(3)
			->get();
	}
}
