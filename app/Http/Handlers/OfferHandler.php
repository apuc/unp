<?php

namespace App\Http\Handlers;

use Illuminate\Http\Request;

class OfferHandler
{
	/**
	 *
	 *
	 */

	public function bookmakers($id, $type, $scope)
	{
		$bookmakers = \App\Bookmaker::query()
			->with([
				'offers' => function ($query) use ($id, $type, $scope) {
					$query->whereHas('outcome', function ($query) use ($id, $type, $scope) {
						$query
							->where('match_id', $id)
							->where('outcometype_id', function ($query) use ($type) {
								$query
									->select('outcometypes.id')
									->from('outcometypes')
									->where('outcometypes.slug', $type)
								;
							})
							->where('outcomescope_id', function ($query) use ($scope) {
								$query
									->select('outcomescopes.id')
									->from('outcomescopes')
									->where('outcomescopes.slug', $scope)
								;
							})
						;
					});
				},
				'offers.outcome.outcometype',
				'offers.outcome.outcomesubtype',
				'offers.outcome.outcomescope',
			])
			->whereHas('offers.outcome', function ($query) use ($id, $type, $scope) {
				$query
					->where('match_id', $id)
					->where('outcometype_id', function ($query) use ($type) {
						$query
							->select('outcometypes.id')
							->from('outcometypes')
							->where('outcometypes.slug', $type)
						;
					})
					->where('outcomescope_id', function ($query) use ($scope) {
						$query
							->select('outcomescopes.id')
							->from('outcomescopes')
							->where('outcomescopes.slug', $scope)
						;
					})
				;
			})
			->where('is_enabled', 1)
			->sortBy('name', 'asc')
			->get()
		;

		return $bookmakers;
	}
}
