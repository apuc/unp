<?php

namespace App\Queries\Site\Match;

use App\Queries\Query;

class OffersQuery extends Query
{
	public function run()
	{
		$match = \App\Match::query()
			->select('matches.id')
			->with([
				'outcomes' => function ($query) {
					$query
						->whereIn('outcometype_id', function ($query) {
							$query
								->select('outcometypes.id')
								->from('outcometypes')
								->whereIn('outcometypes.slug', ['1x2', '12', 'dc', 'oe', 'bts']);
						})
						->whereIn('outcomescope_id', function ($query) {
							$query
								->select('outcomescopes.id')
								->from('outcomescopes')
								->whereIn('outcomescopes.slug', ['ord', '1h', '2h']);
						})
						->whereExists(function ($query) {
							$query
								->select('offers.id')
								->from('offers')
								->whereColumn('offers.outcome_id', 'outcomes.id');
						});
				},
				'outcomes.outcometype',
				'outcomes.outcomesubtype',
				'outcomes.outcomescope',
				'outcomes.offers.bookmaker' => function ($query) {
					$query
						->where('is_enabled', 1)
						->sortBy('name', 'asc');
				},
			])
			->where('matches.id', $this->value('match_id'))
			->whereHas('participants', function ($query) {
				$query
					->select('participants.id')
					->skip(1)
					->take(1);
			})
			->first();

		return call_user_func(function () use ($match) {
			if (null === $match)
				return [];

			return call_user_func(function () use ($match) {
				// собираем все возможные outcometypes
				$outcometypes = [];
				// листаем исходы
				foreach ($match->outcomes as $outcome)
					// если тип исхода еще нет в массиве
					if (!isset($outcometypes[$outcome->outcometype->slug]))
						// собираем для типа инфу
						$outcometypes[$outcome->outcometype->slug] = call_user_func(function ($outcometype) use ($match) {
							// собираем все возможные outcomescopes
							$outcomescopes = [];
							// листаем исходы
							foreach ($match->outcomes as $outcome)
								// если типы исхода совпадают
								if ($outcome->outcometype->slug == $outcometype)
									// если периода еще нет в массиве
									if (!isset($outcomescopes[$outcome->outcomescope->slug]))
										// собираем всю инфу для периода
										$outcomescopes[$outcome->outcomescope->slug] = call_user_func(function ($outcometype, $outcomescope) use ($match) {
											// собираем все возмодных букмекеров
											$bookmakers = [];
											// листаем исходы
											foreach ($match->outcomes as $outcome)
												// если типы и периоды совпадают
												if ($outcome->outcometype->slug == $outcometype && $outcome->outcomescope->slug == $outcomescope)
													// листаем коэффициенты
													foreach ($outcome->offers as $offer) {
														// если не существует букмекер в массиве
														if (!isset($bookmakers[$offer->bookmaker_id]))
															$bookmakers[$offer->bookmaker_id] = [
																'name'		=> $offer->bookmaker->name,
																'logo'		=> null !== $offer->bookmaker->logo ? '/storage/bookmakers/' . $offer->bookmaker->logo : null,
																'site'		=> $offer->bookmaker->site,
																'bonus'		=> $offer->bookmaker->bonus,
																'offers'	=> [],
															];

														// заполняем коэффициентом
														$bookmakers[$offer->bookmaker_id]['offers'][] = [
															'team_id'				=> $outcome->team_id,
															'odds_current'			=> $offer->odds_current,
															'odds_old'				=> $offer->odds_old,
															'has_offers'			=> $offer->has_offers,
															'outcome_id'			=> $outcome->id,
															'outcometype_slug'		=> $outcome->outcometype->slug,
															'outcomescope_slug'		=> $outcome->outcomescope->slug,
															'outcomesubtype_slug'	=> $outcome->outcomesubtype->slug,
															'outcometype_name'		=> $outcome->outcometype->name,
															'outcomescope_name'		=> $outcome->outcomescope->name,
															'outcomesubtype_name'	=> $outcome->outcomesubtype->name,
														];
													}

											return $bookmakers;

										}, $outcometype, $outcome->outcomescope->slug);

							return $outcomescopes;
						}, $outcome->outcometype->slug);

				return $outcometypes;
			});
		});
	}

	/**
	 *
	 *
	 */

	public function findOrFail($id)
	{
		$dataset = $this->where('match_id', $id)->get();

		if (!isset($dataset))
			abort(404);

		return $dataset;
	}
}
