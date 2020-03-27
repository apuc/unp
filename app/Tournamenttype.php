<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Tournamenttype extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'sport_id',
		'name',
	];

	protected $sortable = [
		'sport',
		'name',
		'tournaments_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'sport_id'	=> 'required|exists:sports,id',
		'name' 		=> 'required|min:2|max:255|unique_with:tournamenttypes,sport_id',
	];

	// Incoming Relations

	public function sport()
	{
		return $this->belongsTo('App\Sport');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['sport'])->select('tournamenttypes.*');
	}

	// Outgoing Relations

	public function tournaments()
	{
		return $this->hasMany('App\Tournament');
	}

	// Sort By Relations

	public function scopeSortBySport($query, $direction = null)
	{
		$query->orderBy('sports.name', $direction)
			->join('sports', 'tournamenttypes.sport_id', '=', 'sports.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('tournamenttypes.name', $direction);
	}

	// Sort By Counters

	public function scopeSortByTournamentsCount($query, $direction = null)
	{
		$query->orderBy('tournaments_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('tournamenttypes.name', 'like', "%{$value}%");
	}
}
