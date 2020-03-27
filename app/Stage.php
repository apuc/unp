<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Stage extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'season_id',
		'gender_id',
		'country_id',
		'name',
		'external_id',
	];

	protected $sortable = [
		'tournament',
		'season',
		'gender',
		'country',
		'name',
		'external_id',
		'matches_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'season_id'		=> 'required|exists:seasons,id',
		'gender_id'		=> 'required|exists:genders,id',
		'country_id'	=> 'required|exists:countries,id',
		'name' 			=> 'required|min:2|max:255|unique_with:stages,country_id,season_id,gender_id',
		'external_id'	=> 'required|integer|unique:stages,external_id',
	];

	// Incoming Relations

	public function season()
	{
		return $this->belongsTo('App\Season');
	}

	public function gender()
	{
		return $this->belongsTo('App\Gender');
	}

	public function country()
	{
		return $this->belongsTo('App\Country');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['season.tournament', 'gender', 'country'])->select('stages.*');
	}

	// Outgoing Relations

	public function matches()
	{
		return $this->hasMany('App\Match');
	}

	// Sort By Relations

	public function scopeSortBySeason($query, $direction = null)
	{
		$query->orderBy('seasons.name', $direction)
			->join('seasons', 'stages.season_id', '=', 'seasons.id');
	}

	public function scopeSortByGender($query, $direction = null)
	{
		$query->orderBy('genders.name', $direction)
			->join('genders', 'stages.gender_id', '=', 'genders.id');
	}

	public function scopeSortByCountry($query, $direction = null)
	{
		$query->orderBy('countries.name', $direction)
			->join('countries', 'stages.country_id', '=', 'countries.id');
	}

	public function scopeSortByTournament($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction)
			->join('seasons', 'stages.season_id', '=', 'seasons.id')
			->join('tournaments', 'seasons.tournament_id', '=', 'tournaments.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('stages.name', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('stages.external_id', $direction);
	}

	// Sort By Counters

	public function scopeSortByMatchesCount($query, $direction = null)
	{
		$query->orderBy('matches_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('stages.name', 'like', "%{$value}%");
	}
}
