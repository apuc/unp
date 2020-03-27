<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Tournament extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'sport_id',
		'gender_id',
		'tournamenttype_id',
		'external_id',
		'is_top',
		'logo',
		'name',
		'position',
	];

	protected $sortable = [
		'id',
		'sport',
		'gender',
		'external_id',
		'tournamenttype_id',
		'name',
		'is_top',
		'position',
		'seasons_count',
		'tournamentposts_count',
		'tournamentbriefs_count',
	];

	protected $filterable = [
		'id',
		'name',
		'sport',
		'gender',
		'external',
		'tournamenttype',
		'is_top',
		'position',
	];

	public static $rules = [
		'sport_id'			=> 'required|exists:sports,id',
		'gender_id'			=> 'required|exists:genders,id',
		'tournamenttype_id'	=> 'nullable|exists:tournamenttypes,id',
		'name' 				=> 'required|min:2|max:255|unique_with:tournaments,sport_id,gender_id',
		'external_id'		=> 'required|integer|unique:tournaments,external_id',
		'is_top'			=> 'nullable|boolean',
		'position'			=> 'nullable|integer|unique:tournaments,position',
		'logo'				=> 'nullable|image|max:2048',
	];

	// Incoming Relations

	public function sport()
	{
		return $this->belongsTo('App\Sport');
	}

	public function gender()
	{
		return $this->belongsTo('App\Gender');
	}

	public function tournamenttype()
	{
		return $this->belongsTo('App\Tournamenttype');
	}

	// Outgoing Relations

	public function seasons()
	{
		return $this->hasMany('App\Season');
	}

	public function posttournaments()
	{
		return $this->hasMany('App\Posttournament');
	}

	public function brieftournaments()
	{
		return $this->hasMany('App\Brieftournament');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['sport', 'gender', 'tournamenttype'])->select('tournaments.*');
	}

	// Sort By Relations

	public function scopeSortBySport($query, $direction = null)
	{
		$query->orderBy('sports.name', $direction)
			->join('sports', 'tournaments.sport_id', '=', 'sports.id');
	}

	public function scopeSortByGender($query, $direction = null)
	{
		$query->orderBy('actiongenders.name', $direction)
			->join('genders', 'tournaments.gender_id', '=', 'genders.id');
	}

	public function scopeSortByTournamenttype($query, $direction = null)
	{
		$query->orderBy('tournamenttypes.name', $direction)
			->join('tournamenttypes', 'tournaments.tournamenttype_id', '=', 'tournamenttypes.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('tournaments.external_id', $direction);
	}

	public function scopeSortByIsTop($query, $direction = null)
	{
		$query->orderBy('tournaments.is_top', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('tournaments.position', $direction);
	}

	// Sort By Counters

	public function scopeSortBySeasonsCount($query, $direction = null)
	{
		$query->orderBy('seasons_count', $direction);
	}

	public function scopeSortByTournamentbriefsCount($query, $direction = null)
	{
		$query->orderBy('tournamentbriefs_count', $direction);
	}

	public function scopeSortByTournamentpostsCount($query, $direction = null)
	{
		$query->orderBy('tournamentposts_count', $direction);
	}

	// Filter

	public function scopeFilterById($query, $value)
	{
		if (filled($value))
			$query->where('tournaments.id', '=', $value);
	}

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('tournaments.name', 'like', "%{$value}%");
	}

	public function scopeFilterByExternal($query, $value)
	{
		if (filled($value))
			$query->where('tournaments.external_id', '=', $value);
	}
}
