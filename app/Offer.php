<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Offer extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'bookmaker_id',
		'outcome_id',
		'odds_current',
		'odds_old',
		'coupon',
		'external_id',
		'has_offers',
	];

	protected $sortable = [
		'bookmaker',
		'outcome',
		'odds_current',
		'odds_old',
		'external_id',
		'has_offers',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'bookmaker_id'	=> 'required|exists:bookmakers,id',
		'outcome_id'	=> 'required|exists:outcomes,id|unique_with:offers,bookmaker_id',
		'odds_current'	=> 'required|numeric',
		'odds_old'		=> 'required|numeric',
		'coupon'		=> 'nullable|max:255',
		'external_id'	=> 'required|integer|unique:offers,external_id',
		'has_offers'	=> 'nullable|boolean',
	];

	// Incoming Relations

	public function bookmaker()
	{
		return $this->belongsTo('App\Bookmaker');
	}

	public function outcome()
	{
		return $this->belongsTo('App\Outcome');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['bookmaker', 'outcome.outcometype', 'outcome.outcomescope', 'outcome.outcomesubtype', 'outcome.match'])->select('offers.*');
	}

	// Sort By Relations

	public function scopeSortByBookmaker($query, $direction = null)
	{
		$query->orderBy('bookmakers.name', $direction)
			->join('bookmakers', 'offers.bookmaker_id', '=', 'bookmakers.id')
		;
	}

	public function scopeSortByOutcome($query, $direction = null)
	{
		$query->orderBy('matches.name', $direction)
			->join('outcomes', 'offers.outcome_id', '=', 'outcomes.id')
			->join('matches', 'outcomes.match_id', '=', 'matches.id')
		;
	}

	// Sort By Fields

	public function scopeSortByOddsCurrent($query, $direction = null)
	{
		$query->orderBy('offers.odds_current', $direction);
	}

	public function scopeSortByOddsOld($query, $direction = null)
	{
		$query->orderBy('offers.odds_old', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('offers.external_id', $direction);
	}

	public function scopeSortByHasOffers($query, $direction = null)
	{
		$query->orderBy('offers.has_offers', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where(function () use ($value) {
				$query
					->whereHas('bookmaker', function ($query) use ($value) {
						$query->where('bookmakers.name', 'like', "{$value}");
					})
					//->orWhereHas('outcome', function ($query) use ($value) {
					//	$query->where('outcomes.name', 'like', "{$value}");
					//})
				;
			});
	}
}
