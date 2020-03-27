<?php

namespace App\Http\Controllers\Debug;

use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Illuminate\Routing\Controller;

class MatchController extends Controller
{

	/**
	 *
	 *
	 */

	public function index(Request $request)
	{
		$day		= $request->has('started_at') ? $request->started_at : now()->format('Y-m-d');
		$dataset	= collect();

		$sports = $this->getSports($day);

		foreach ($sports as $sport)
			$dataset->push(collect([
				'sport'			=> $sport,
				'tournaments'	=> call_user_func(function () use ($day, $sport) {
					$tournaments	= $this->getTournaments($day, $sport->id);
					$result			= collect();

					foreach ($tournaments as $tournament)
						$result->push(collect([
							'tournament'	=> $tournament,
							'matches'		=> $this->getMatches($day, $tournament->id),
						]));

					return $result;
				}),
			]));

		return view('page.debug.match.index', compact(
			'dataset'
		));
	}

	/**
	 *
	 *
	 */

	public function show($id)
	{
		if (null === ($match = $this->getMatch($id)))
			abort(404);

		$outcomes = collect([
			'1x2' => [
				'ord'	=> $this->getBookmakers('1x2', 'ord', $match),
				'1h'	=> $this->getBookmakers('1x2', '1h', $match),
				'2h'	=> $this->getBookmakers('1x2', '2h', $match),
			],
			'12' => [
				'ord'	=> $this->getBookmakers('12', 'ord', $match),
				'1h'	=> $this->getBookmakers('12', '1h', $match),
				'2h'	=> $this->getBookmakers('12', '2h', $match),
			],
			'dc' => [
				'ord'	=> $this->getBookmakers('dc', 'ord', $match),
				'1h'	=> $this->getBookmakers('dc', '1h', $match),
				'2h'	=> $this->getBookmakers('dc', '2h', $match),
			],
			'oe' => [
				'ord'	=> $this->getBookmakers('oe', 'ord', $match),
				'1h'	=> $this->getBookmakers('oe', '1h', $match),
				'2h'	=> $this->getBookmakers('oe', '2h', $match),
			],
			'bts' => [
				'ord'	=> $this->getBookmakers('bts', 'ord', $match),
				'1h'	=> $this->getBookmakers('bts', '1h', $match),
				'2h'	=> $this->getBookmakers('bts', '2h', $match),
			],
		]);

		return view('page.debug.match.show', compact(
			'match',
			'outcomes'
		));
	}

	/**
	 *
	 *
	 */

	private function getBookmakers($type, $scope, $match)
	{
		$bookmakers	= collect();
		$outcomes	= $this->getOutcome($type, $scope, $match->id);

		$offers = DB::connection('api')
			->table('bettingoffer')
			->select([
				'bettingoffer.*',
				'odds_provider.name as odds_provider_name',
			])
			->leftJoin('odds_provider', function ($query) {
				$query->whereColumn('bettingoffer.odds_providerFK', 'odds_provider.id');
			})
			->where('bettingoffer.del', 'no')
			->where('bettingoffer.active', 'yes')
			->whereIn('outcomeFK', $outcomes->map(function ($outcome) {
				return $outcome->id;
			})->toArray())
			->get();

		foreach ($offers as $offer) {
			$outcome = $outcomes->filter(function ($outcome) use ($offer) {
				return $outcome->id == $offer->outcomeFK;
			})->first();

			if (!$bookmakers->has($offer->odds_providerFK))
				$bookmakers->put($offer->odds_providerFK, collect([
					'name'		=> $offer->odds_provider_name,
					'offers'	=> collect(),
				]));

			switch ($type) {
				case 'dc':
				case '12':
				case '1x2':
					$bookmakers->get($offer->odds_providerFK)->get('offers')->put(
						(null === $outcome->event_participants_number ? 0 : $outcome->event_participants_number),
						$offer
					);
					break;

				case 'bts':
				case 'oe':
					$bookmakers->get($offer->odds_providerFK)->get('offers')->put(
						$outcome->outcome_subtype_name,
						$offer
					);
					break;
			}
		}

		return $bookmakers;
	}

	/**
	 *
	 *
	 */

	private function getOutcome($type, $scope, $match_id)
	{
		return DB::connection('api')
			->table('outcome')
			->select([
				'outcome.*',
				'event_participants.number as event_participants_number',
				'outcome_subtype.name as outcome_subtype_name',
			])
			->where('outcome.object', 'event')
			->where('outcome.objectFK', $match_id)
			->leftJoin('event_participants', function ($query) use ($match_id) {
				$query
					->whereColumn('event_participants.participantFK', 'outcome.iparam')
					->where('event_participants.eventFK', $match_id);
			})
			->leftJoin('outcome_subtype', function ($query) use ($match_id) {
				$query->whereColumn('outcome.outcome_subtypeFK', 'outcome_subtype.id');
			})
			->whereExists(function ($query) use ($type) {
				$query
					->select('outcome_type.id')
					->from('outcome_type')
					->whereColumn('outcome_type.id', 'outcome.outcome_typeFK')
					->where('outcome_type.name', $type)
					->where('outcome_type.del', 'no')
				;
			})
			->whereExists(function ($query) use ($scope) {
				$query
					->select('outcome_scope.id')
					->from('outcome_scope')
					->whereColumn('outcome_scope.id', 'outcome.outcome_scopeFK')
					->where('outcome_scope.name', $scope)
					->where('outcome_scope.del', 'no')
				;
			})
			->get();
	}

	/**
	 *
	 *
	 */

	private function getSports($day)
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		return DB::connection('api')
			->table("{$api}.sport")
			->select("{$api}.sport.*")
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.sports")
					->select("{$main}.sports.name")
					->whereColumn("{$main}.sports.external_id", "{$api}.sport.id");

				return "({$query->toSql()}) as main_name";
			}))
			->where("{$api}.sport.del", "no")
			->whereExists(function ($query) use ($day, $api) {
				$query
					->select("{$api}.tournament_template.id")
					->from("{$api}.tournament_template")
					->whereColumn("{$api}.sport.id", "{$api}.tournament_template.sportFK")
					->where("{$api}.tournament_template.del", "no")
					->whereExists(function ($query) use ($day, $api) {
						$query
							->select("{$api}.tournament.id")
							->from("{$api}.tournament")
							->whereColumn("{$api}.tournament_template.id", "{$api}.tournament.tournament_templateFK")
							->where("{$api}.tournament.del", "no")
							->whereExists(function ($query) use ($day, $api) {
								$query
									->select("{$api}.tournament_stage.id")
									->from("{$api}.tournament_stage")
									->whereColumn("{$api}.tournament.id", "{$api}.tournament_stage.tournamentFK")
									->where("{$api}.tournament_stage.del", "no")
									->whereExists(function ($query) use ($day, $api) {
										$query
											->select("{$api}.event.id")
											->from("{$api}.event")
											->whereColumn("{$api}.tournament_stage.id", "{$api}.event.tournament_stageFK")
											->where("{$api}.event.del", "no")
											->whereDate("{$api}.event.startdate", "=", $day);
									});
							});
					});
			})
			->get();
	}

	/**
	 *
	 *
	 */

	private function getTournaments($day, $sport_id)
	{
		$api	= config('database.connections.api.database');
		$main	= config('database.connections.' . config('database.default') . '.database');

		return DB::connection('api')
			->table("{$api}.tournament_template")
			->select([
				"{$api}.tournament_template.id",
				"{$api}.tournament_template.name as external_name",
				"{$api}.language.name",
				"{$api}.tournament_template.sportFK",
				"{$api}.tournament_template.gender",
				"{$api}.tournament_template.ut",
				"{$api}.tournament_template.del",
			])
			->selectRaw(call_user_func(function () use ($main, $api) {
				$query = DB::table("{$main}.tournaments")
					->select("{$main}.tournaments.name")
					->whereColumn("{$main}.tournaments.external_id", "{$api}.tournament_template.id");

				return "({$query->toSql()}) as main_name";
			}))
			->leftJoin("{$api}.language", function ($query) use ($api) {
				$query
					->whereColumn("{$api}.language.objectFK", "{$api}.tournament_template.id")
					->where("{$api}.language.object", "{$api}.tournament_template")
					->where("{$api}.language.del", "no")
					->whereExists(function ($query) use ($api) {
						$query
							->select("{$api}.language_type.id")
							->from("{$api}.language_type")
							->whereColumn("{$api}.language_type.id", "{$api}.language.language_typeFK")
							->where("{$api}.language_type.name", config('app.locale'))
							->where("{$api}.language_type.del", "no")
						;
					})
				;
			})
			->where("{$api}.tournament_template.del", "no")
			->where("{$api}.tournament_template.sportFK", $sport_id)
			->whereExists(function ($query) use ($day, $api) {
				$query
					->select("{$api}.tournament.id")
					->from("{$api}.tournament")
					->whereColumn("{$api}.tournament_template.id", "{$api}.tournament.tournament_templateFK")
					->where("{$api}.tournament.del", "no")
					->whereExists(function ($query) use ($day, $api) {
						$query
							->select("{$api}.tournament_stage.id")
							->from("{$api}.tournament_stage")
							->whereColumn("{$api}.tournament.id", "{$api}.tournament_stage.tournamentFK")
							->where("{$api}.tournament_stage.del", "no")
							->whereExists(function ($query) use ($day, $api) {
								$query
									->select("{$api}.event.id")
									->from("{$api}.event")
									->whereColumn("{$api}.tournament_stage.id", "{$api}.event.tournament_stageFK")
									->where("{$api}.event.del", "no")
									->whereDate("{$api}.event.startdate", "=", $day);
							});
					});
			})
			->get();
	}

	/**
	 *
	 *
	 */

	private function getMatches($day, $tournament_id)
	{
		return DB::connection('api')
			->table('event')
			->select([
				'event.id',
				'event.name as external_name',

				'event.startdate',
				'event.status_type',

				'event.tournament_stageFK',

				'language.name',
				'event.ut',
				'event.del',
			])
			// odds1_current
			->selectRaw(call_user_func(function () {
				$query = DB::table('outcome')
					->selectRaw(call_user_func(function () {
						$query = DB::table('bettingoffer')
							->select('bettingoffer.odds')
							->whereColumn('bettingoffer.outcomeFK', 'outcome.id')
							->where('bettingoffer.active', '?')
							->where('bettingoffer.del', '?')
							->orderBy('bettingoffer.odds', "DESC")
							->skip(0)
							->take(1)
						;

						return "({$query->toSql()}) as odds_current";
					}))
					->where('outcome.object', '?')
					->whereColumn('outcome.objectFK', 'event.id')

					->whereExists(function ($query) {
						$query
							->select('outcome_type.id')
							->from('outcome_type')
							->whereColumn('outcome_type.id', 'outcome.outcome_typeFK')
							->where('outcome_type.name', '?')
							->where('outcome_type.del', '?')
						;
					})
					->whereExists(function ($query) {
						$query
							->select('outcome_scope.id')
							->from('outcome_scope')
							->whereColumn('outcome_scope.id', 'outcome.outcome_scopeFK')
							->where('outcome_scope.name', '?')
							->where('outcome_scope.del', "?")
						;
					})
					->whereExists(function ($query) {
						$query
							->select('event_participants.id')
							->from('event_participants')
							->whereColumn('event_participants.participantFK', 'outcome.iparam')
							->whereColumn('event_participants.eventFK', 'event.id')
							->where('event_participants.number', '?')
						;
					})
					->skip(0)
					->take(1);

				return "({$query->toSql()}) as odds1_current";
			}), ['yes', 'no', 'event', '1x2', 'no', 'ord', 'no', '1'])

			// oddsx_current
			->selectRaw(call_user_func(function () {
				$query = DB::table('outcome')
					->selectRaw(call_user_func(function () {
						$query = DB::table('bettingoffer')
							->select('bettingoffer.odds')
							->whereColumn('bettingoffer.outcomeFK', 'outcome.id')
							->where('bettingoffer.active', '?')
							->where('bettingoffer.del', '?')
							->orderBy('bettingoffer.odds', "DESC")
							->skip(0)
							->take(1)
						;

						return "({$query->toSql()}) as odds_current";
					}))
					->where('outcome.object', '?')
					->whereColumn('outcome.objectFK', 'event.id')

					->whereExists(function ($query) {
						$query
							->select('outcome_type.id')
							->from('outcome_type')
							->whereColumn('outcome_type.id', 'outcome.outcome_typeFK')
							->where('outcome_type.name', '?')
							->where('outcome_type.del', '?')
						;
					})
					->whereExists(function ($query) {
						$query
							->select('outcome_scope.id')
							->from('outcome_scope')
							->whereColumn('outcome_scope.id', 'outcome.outcome_scopeFK')
							->where('outcome_scope.name', '?')
							->where('outcome_scope.del', "?")
						;
					})
					->where('outcome.iparam', '?')
					->skip(0)
					->take(1);

				return "({$query->toSql()}) as oddsx_current";
			}), ['yes', 'no', 'event', '1x2', 'no', 'ord', 'no', '0'])

			// odds2_current
			->selectRaw(call_user_func(function () {
				$query = DB::table('outcome')
					->selectRaw(call_user_func(function () {
						$query = DB::table('bettingoffer')
							->select('bettingoffer.odds')
							->whereColumn('bettingoffer.outcomeFK', 'outcome.id')
							->where('bettingoffer.active', '?')
							->where('bettingoffer.del', '?')
							->orderBy('bettingoffer.odds', "DESC")
							->skip(0)
							->take(1)
						;

						return "({$query->toSql()}) as odds_current";
					}))
					->where('outcome.object', '?')
					->whereColumn('outcome.objectFK', 'event.id')

					->whereExists(function ($query) {
						$query
							->select('outcome_type.id')
							->from('outcome_type')
							->whereColumn('outcome_type.id', 'outcome.outcome_typeFK')
							->where('outcome_type.name', '?')
							->where('outcome_type.del', '?')
						;
					})
					->whereExists(function ($query) {
						$query
							->select('outcome_scope.id')
							->from('outcome_scope')
							->whereColumn('outcome_scope.id', 'outcome.outcome_scopeFK')
							->where('outcome_scope.name', '?')
							->where('outcome_scope.del', "?")
						;
					})
					->whereExists(function ($query) {
						$query
							->select('event_participants.id')
							->from('event_participants')
							->whereColumn('event_participants.participantFK', 'outcome.iparam')
							->whereColumn('event_participants.eventFK', 'event.id')
							->where('event_participants.number', '?')
						;
					})
					->skip(0)
					->take(1);

				return "({$query->toSql()}) as odds2_current";
			}), ['yes', 'no', 'event', '1x2', 'no', 'ord', 'no', '2'])

			// bookmaker 1
			->selectRaw(call_user_func(function () {
				$query = DB::table('outcome')
					->selectRaw(call_user_func(function () {
						$query = DB::table('bettingoffer')
							->select('odds_provider.name')
							->whereColumn('bettingoffer.outcomeFK', 'outcome.id')
							->leftJoin('odds_provider', function ($query) {
								$query->whereColumn('bettingoffer.odds_providerFK', 'odds_provider.id');
							})
							->where('bettingoffer.active', '?')
							->where('bettingoffer.del', '?')
							->orderBy('bettingoffer.odds', "DESC")
							->skip(0)
							->take(1)
						;

						return "({$query->toSql()}) as bookmaker";
					}))
					->where('outcome.object', '?')
					->whereColumn('outcome.objectFK', 'event.id')

					->whereExists(function ($query) {
						$query
							->select('outcome_type.id')
							->from('outcome_type')
							->whereColumn('outcome_type.id', 'outcome.outcome_typeFK')
							->where('outcome_type.name', '?')
							->where('outcome_type.del', '?')
						;
					})
					->whereExists(function ($query) {
						$query
							->select('outcome_scope.id')
							->from('outcome_scope')
							->whereColumn('outcome_scope.id', 'outcome.outcome_scopeFK')
							->where('outcome_scope.name', '?')
							->where('outcome_scope.del', "?")
						;
					})
					->whereExists(function ($query) {
						$query
							->select('event_participants.id')
							->from('event_participants')
							->whereColumn('event_participants.participantFK', 'outcome.iparam')
							->whereColumn('event_participants.eventFK', 'event.id')
							->where('event_participants.number', '?')
						;
					})
					->skip(0)
					->take(1);

				return "({$query->toSql()}) as bookmaker1_name";
			}), ['yes', 'no', 'event', '1x2', 'no', 'ord', 'no', '1'])

			// bookmaker x
			->selectRaw(call_user_func(function () {
				$query = DB::table('outcome')
					->selectRaw(call_user_func(function () {
						$query = DB::table('bettingoffer')
							->select('odds_provider.name')
							->whereColumn('bettingoffer.outcomeFK', 'outcome.id')
							->leftJoin('odds_provider', function ($query) {
								$query->whereColumn('bettingoffer.odds_providerFK', 'odds_provider.id');
							})
							->where('bettingoffer.active', '?')
							->where('bettingoffer.del', '?')
							->orderBy('bettingoffer.odds', "DESC")
							->skip(0)
							->take(1)
						;

						return "({$query->toSql()}) as bookmaker";
					}))
					->where('outcome.object', '?')
					->whereColumn('outcome.objectFK', 'event.id')

					->whereExists(function ($query) {
						$query
							->select('outcome_type.id')
							->from('outcome_type')
							->whereColumn('outcome_type.id', 'outcome.outcome_typeFK')
							->where('outcome_type.name', '?')
							->where('outcome_type.del', '?')
						;
					})
					->whereExists(function ($query) {
						$query
							->select('outcome_scope.id')
							->from('outcome_scope')
							->whereColumn('outcome_scope.id', 'outcome.outcome_scopeFK')
							->where('outcome_scope.name', '?')
							->where('outcome_scope.del', "?")
						;
					})
					->where('outcome.iparam', '?')
					->skip(0)
					->take(1);

				return "({$query->toSql()}) as bookmakerx_name";
			}), ['yes', 'no', 'event', '1x2', 'no', 'ord', 'no', '0'])

			// bookmaker 2
			->selectRaw(call_user_func(function () {
				$query = DB::table('outcome')
					->selectRaw(call_user_func(function () {
						$query = DB::table('bettingoffer')
							->select('odds_provider.name')
							->whereColumn('bettingoffer.outcomeFK', 'outcome.id')
							->leftJoin('odds_provider', function ($query) {
								$query->whereColumn('bettingoffer.odds_providerFK', 'odds_provider.id');
							})
							->where('bettingoffer.active', '?')
							->where('bettingoffer.del', '?')
							->orderBy('bettingoffer.odds', "DESC")
							->skip(0)
							->take(1)
						;

						return "({$query->toSql()}) as bookmaker";
					}))
					->where('outcome.object', '?')
					->whereColumn('outcome.objectFK', 'event.id')

					->whereExists(function ($query) {
						$query
							->select('outcome_type.id')
							->from('outcome_type')
							->whereColumn('outcome_type.id', 'outcome.outcome_typeFK')
							->where('outcome_type.name', '?')
							->where('outcome_type.del', '?')
						;
					})
					->whereExists(function ($query) {
						$query
							->select('outcome_scope.id')
							->from('outcome_scope')
							->whereColumn('outcome_scope.id', 'outcome.outcome_scopeFK')
							->where('outcome_scope.name', '?')
							->where('outcome_scope.del', "?")
						;
					})
					->whereExists(function ($query) {
						$query
							->select('event_participants.id')
							->from('event_participants')
							->whereColumn('event_participants.participantFK', 'outcome.iparam')
							->whereColumn('event_participants.eventFK', 'event.id')
							->where('event_participants.number', '?')
						;
					})
					->skip(0)
					->take(1);

				return "({$query->toSql()}) as bookmaker2_name";
			}), ['yes', 'no', 'event', '1x2', 'no', 'ord', 'no', '2'])

			->leftJoin('language', function ($query) {
				$query
					->whereColumn('language.objectFK', 'event.id')
					->where('language.object', 'event')
					->where('language.del', 'no')
					->whereExists(function ($query) {
						$query
							->select('language_type.id')
							->from('language_type')
							->whereColumn('language_type.id', 'language.language_typeFK')
							->where('language_type.name', config('app.locale'))
							->where('language_type.del', 'no')
						;
					})
				;
			})
			->where('event.del', 'no')
			->whereDate('event.startdate', '=', $day)
			->whereExists(function ($query) use ($tournament_id) {
				$query
					->select('tournament_stage.id')
					->from('tournament_stage')
					->whereColumn('tournament_stage.id', 'event.tournament_stageFK')
					->whereExists(function ($query) use ($tournament_id) {
						$query
							->select('tournament.id')
							->from('tournament')
							->whereColumn('tournament.id', 'tournament_stage.tournamentFK')
							->where('tournament.tournament_templateFK', $tournament_id);
					});
			})
			->get();
	}

	/**
	 *
	 *
	 */

	private function getMatch($match_id)
	{
		return DB::connection('api')
			->table('event')
			->select([
				'event.id',
				'event.name as external_name',

				'event.startdate',
				'event.status_type',

				'p1.id as team1_id',
				'p2.id as team2_id',

				'p1.name as team1_name',
				'p2.name as team2_name',

				'event.tournament_stageFK',

				'language.name',
				'event.ut',
				'event.del',
			])
			->selectRaw(call_user_func(function () {
				$query = DB::table('result')
					->select('result.value')
					->whereColumn('result.event_participantsFK', 'ep1.id')
					->where('result.del', '?')
					->where('result.value', '>=', '0')
					->orderBy('result.ut', 'DESC')
					->take(1)
				;

				return "({$query->toSql()}) as score1";
			}), ['no', '0'])
			->selectRaw(call_user_func(function () {
				$query = DB::table('result')
					->select('result.value')
					->whereColumn('result.event_participantsFK', 'ep2.id')
					->where('result.del', '?')
					->where('result.value', '>=', '0')
					->orderBy('result.ut', 'DESC')
					->take(1)
				;

				return "({$query->toSql()}) as score2";
			}), ['no', '0'])
			->selectRaw(call_user_func(function () {
				$query = DB::table('tournament_stage')
					->select('tournament_template.name')
					->from('tournament_stage')
					->whereColumn('tournament_stage.id', 'event.tournament_stageFK')
					->leftJoin('tournament', function ($query) {
						$query->whereColumn('tournament_stage.tournamentFK', 'tournament.id');
					})
					->leftJoin('tournament_template', function ($query) {
						$query->whereColumn('tournament.tournament_templateFK', 'tournament_template.id');
					});

				return "({$query->toSql()}) as tournament_name";
			}))
			->leftJoin('language', function ($query) {
				$query
					->whereColumn('language.objectFK', 'event.id')
					->where('language.object', 'event')
					->where('language.del', 'no')
					->whereExists(function ($query) {
						$query
							->select('language_type.id')
							->from('language_type')
							->whereColumn('language_type.id', 'language.language_typeFK')
							->where('language_type.name', config('app.locale'))
							->where('language_type.del', 'no')
						;
					})
				;
			})
			->leftJoin('event_participants as ep1', function ($query) {
				$query
					->whereColumn('ep1.eventFK', 'event.id')
					->where('ep1.number', 1);
			})
			->leftJoin('participant as p1', function ($query) {
				$query->whereColumn('p1.id', 'ep1.participantFK');
			})
			->leftJoin('event_participants as ep2', function ($query) {
				$query
					->whereColumn('ep2.eventFK', 'event.id')
					->where('ep2.number', 2);
			})
			->leftJoin('participant as p2', function ($query) {
				$query->whereColumn('p2.id', 'ep2.participantFK');
			})
			->where('event.del', 'no')
			->where('event.id', $match_id)
			->first();
	}
}
