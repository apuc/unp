<?php

namespace App\Queries\Site\Home;

use App\Queries\Query;

class TournamentsQuery extends Query
{
	public function run()
	{
		return \App\Sport::query()
			->select('sports.*')
			->with([
				'tournaments' => function ($query) {
					$first = clone $query;
					$first
						->select('tournaments.*')
						->selectRaw('1 as `o`')
						->whereNull('tournaments.position')
						->whereHas('seasons.stages.matches', function ($query) {
							$query
								->whereHas('participants', function ($query) {
									$query->skip(1)->take(1);
								})
								->where('matches.started_at', 'like', now()->toDateString() . '%');
						});
		    
					$query
						->select('tournaments.*')
						->selectRaw('0 as `o`')
						->whereNotNull('tournaments.position')
						->whereHas('seasons.stages.matches', function ($query) {
							$query
								->whereHas('participants', function ($query) {
									$query->skip(1)->take(1);
								})
								->where('matches.started_at', 'like', now()->toDateString() . '%');
						})
						->union($first)
						->take(14)
						->orderBy('o', 'asc')
						->orderBy('position', 'asc')
						->orderBy('name', 'asc');
				},
			])
			->where('sports.has_odds', 1)
			->whereHas('tournaments', function ($query) {
				$query
					->select('tournaments.*')
					->whereHas('seasons.stages.matches', function ($query) {
						$query
							->whereHas('participants', function ($query) {
								$query->skip(1)->take(1);
							})
							->where('matches.started_at', 'like', now()->toDateString() . '%');
					});
			})
			->orderBy('sports.position', 'asc')
			->get();
	}
}
