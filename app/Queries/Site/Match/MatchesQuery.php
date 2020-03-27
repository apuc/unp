<?php

namespace App\Queries\Site\Match;

use App\Queries\Query;

class MatchesQuery extends Query
{
	/**
	 *
	 *
	 */

	public function run()
	{
		$sports = \App\Sport::query()
			->select([
				'sports.id',
				'sports.name',
				'sports.icon',
				'sports.slug',
				'sports.position',
			])
			->with([
				'tournaments' => function ($query) {
					$query
						->select("tournaments.*")
						->leftJoin('seasons',		'seasons.tournament_id',	'=', 'tournaments.id')
						->leftJoin('stages',		'stages.season_id',			'=', 'seasons.id')
						->leftJoin('matches',		'matches.stage_id',			'=', 'stages.id')
						->where('matches.started_at', 'like', $this->value('date') . '%')
						->whereExists(function ($query) {
							$query
								->select('participants.id')
								->from('participants')
								->whereColumn('participants.match_id', 'matches.id')
								->skip(1)
								->take(1)
							;
						})
						->groupBy('tournaments.id')
					;
				},
				'tournaments.seasons' => function ($query) {
					$query
						->select("seasons.*")
						->leftJoin('stages',	'stages.season_id', '=', 'seasons.id')
						->leftJoin('matches',	'matches.stage_id', '=', 'stages.id')
						->where('matches.started_at', 'like', $this->value('date') . '%')
						->whereExists(function ($query) {
							$query
								->select('participants.id')
								->from('participants')
								->whereColumn('participants.match_id', 'matches.id')
								->skip(1)
								->take(1)
							;
						})
						->groupBy('seasons.id')
					;
				},
				'tournaments.seasons.stages' => function ($query) {
					$query
						->select("stages.*")
						->leftJoin('matches', 'matches.stage_id', '=', 'stages.id')
						->where('matches.started_at', 'like', $this->value('date') . '%')
						->whereExists(function ($query) {
							$query
								->select('participants.id')
								->from('participants')
								->whereColumn('participants.match_id', 'matches.id')
								->skip(1)
								->take(1)
							;
						})
						->groupBy('stages.id')
					;
				},
				'tournaments.seasons.stages.matches' => function ($query) {
					$query
						->where('matches.started_at', 'like', $this->value('date') . '%')
						->whereExists(function ($query) {
							$query
								->select('participants.id')
								->from('participants')
								->whereColumn('participants.match_id', 'matches.id')
								->skip(1)
								->take(1)
							;
						})
					;
				},
				'tournaments.seasons.stages.matches.participants' => function ($query) {
					$query->orderBy('position', 'asc');
				},
				'tournaments.seasons.stages.matches.participants.team',
				'tournaments.seasons.stages.matches.matchstatus',
			])
			->where('sports.has_odds', 1)
			->orderBy('sports.position', 'asc')
			->get()
		;

		return call_user_func(function () use ($sports) {
			$dataset = [];

			foreach ($sports as $sport)
				$dataset[$sport->slug] = [
					'id'			=> $sport->id,
					'name'			=> $sport->name,
					'icon'			=> null !== $sport->icon ? '/storage/sports/' . $sport->icon : null,
					'position'		=> $sport->position,
					'tournaments'	=> call_user_func(function () use ($sport) {
						// собираем туринры
						$tournaments = [];
						foreach ($sport->tournaments as $tournament)
							$tournaments[$tournament->id] = [
								'name'		=> $tournament->name,
								'is_top'	=> null === $tournament->is_top ? 0 : $tournament->is_top,
								'position'	=> $tournament->position,
								'logo'		=> null !== $tournament->logo ? '/storage/tournaments/' . $tournament->logo : null,
								'matches'	=> call_user_func(function () use ($tournament) {
									// собираем матчи
									$matches = [];

									foreach ($tournament->seasons as $season)
										foreach ($season->stages as $stage)
											foreach ($stage->matches as $match)
												$matches[$match->id] = [
													'time'			=> $match->started_at->format('H:i'),
													'team1_name'	=> $match->participants[0]->team->name,
													'team1_icon'	=> null !== $match->participants[0]->team->logo ? '/storage/teams/' . $match->participants[0]->team->logo : null,
													'team1_score'	=> $match->participants[0]->score,
													'team2_name'	=> $match->participants[1]->team->name,
													'team2_icon'	=> null !== $match->participants[1]->team->logo ? '/storage/teams/' . $match->participants[1]->team->logo : null,
													'team2_score'	=> $match->participants[1]->score,
													'status_id'		=> $match->matchstatus->id,
													'status_name'	=> $match->matchstatus->name,
													'status_slug'	=> $match->matchstatus->slug,
													'odds1_current'	=> is_null($match->odds1_current)	? '0.00' : sprintf("%0.02f", $match->odds1_current),
													'odds1_old'		=> is_null($match->odds1_old)		? '0.00' : sprintf("%0.02f", $match->odds1_old),
													'oddsx_current'	=> is_null($match->oddsx_current)	? '0.00' : sprintf("%0.02f", $match->oddsx_current),
													'oddsx_old'		=> is_null($match->oddsx_old)		? '0.00' : sprintf("%0.02f", $match->oddsx_old),
													'odds2_current'	=> is_null($match->odds2_current)	? '0.00' : sprintf("%0.02f", $match->odds2_current),
													'odds2_old'		=> is_null($match->odds2_old)		? '0.00' : sprintf("%0.02f", $match->odds2_old),
												];

									return $matches;
								}),
							];

						return $tournaments;
					}),
				];

			return $dataset;
		});
	}

	/**
	 *
	 *
	 */

	public function getAll()
	{
		$dataset = collect();
		for ($i = 0; $i <= 7; $i++) {
			$sports = MatchesQuery::where('date', now()->addDay($i)->format('Y-m-d'))->get();

			foreach ($sports as $slug => $sport) {
				// существует ли спорт
				if (!$dataset->has($slug))
					// создаем
					$dataset->put($slug, [
						'id'			=> $sport['id'],
						'name'			=> $sport['name'],
						'icon'			=> $sport['icon'],
						'tournaments'	=> collect(),
					]);

				foreach ($sport['tournaments'] as $tournament_id => $tournament) {
					// существует ли турнир
					if (!$dataset->get($slug)['tournaments']->has($tournament_id))
						// создаем
						$dataset->get($slug)['tournaments']->put($tournament_id, [
							'name'		=> $tournament['name'],
							'logo'		=> $tournament['logo'],
							'matches'	=> collect(),
						]);

					// переносим матчи
					foreach ($tournament['matches'] as $match_id => $match)
						$dataset->get($slug)['tournaments']->get($tournament_id)['matches']->put($match_id, $match);
				}
			}
		}

		return $dataset->map(function ($sport) {
			$sport['tournaments'] = $sport['tournaments']->map(function ($tournament) {
				$tournament['matches'] = $tournament['matches']->toArray();
				return $tournament;
			})->toArray();
			return $sport;
		})->toArray();
	}
}
