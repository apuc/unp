<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Outcome extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'match_id',
		'outcometype_id',
		'outcomescope_id',
		'outcomesubtype_id',
		'team_id',
		'external_id',
	];

	protected $sortable = [
		'tournament',
		'season',
		'stage',
		'match',
		'outcometype',
		'outcomesubtype',
		'outcomescope',
		'team',
		'external_id',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'match_id'			=> 'required|exists:matches,id',
		'outcometype_id'	=> 'required|exists:outcometypes,id',
		'outcomesubtype_id'	=> 'required|exists:outcomesubtypes,id',
		'outcomescope_id'	=> 'required|exists:outcomescopes,id',
		'team_id'			=> 'nullable|exists:teams,id',
		'external_id'		=> 'required|integer|unique:outcomes,external_id',
	];

	// Incoming Relations

	public function team()
	{
		return $this->belongsTo('App\Team');
	}

	public function match()
	{
		return $this->belongsTo('App\Match');
	}

	public function outcometype()
	{
		return $this->belongsTo('App\Outcometype');
	}

	public function outcomesubtype()
	{
		return $this->belongsTo('App\Outcomesubtype');
	}

	public function outcomescope()
	{
		return $this->belongsTo('App\Outcomescope');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['match.stage.season.tournament', 'team', 'outcometype', 'outcomesubtype', 'outcomescope'])->select('outcomes.*');
	}

	// Outgoing Relations

	public function offers()
	{
		return $this->hasMany('App\Offer');
	}

	// Sort By Relations

	public function scopeSortByTeam($query, $direction = null)
	{
		$query->orderBy('teams.name', $direction)
			->join('teams', 'outcomes.team_id', '=', 'teams.id')
		;
	}

	public function scopeSortByMatch($query, $direction = null)
	{
		$query->orderBy('matches.name', $direction)
			->join('matches', 'outcomes.match_id', '=', 'matches.id')
		;
	}

	public function scopeSortByOutcometype($query, $direction = null)
	{
		$query->orderBy('outcometypes.name', $direction)
			->join('outcometypes', 'outcomes.outcometype_id', '=', 'outcometypes.id')
		;
	}

	public function scopeSortByOutcomesubtype($query, $direction = null)
	{
		$query->orderBy('outcomesubtypes.name', $direction)
			->join('outcomesubtypes', 'outcomes.outcomesubtype_id', '=', 'outcomesubtypes.id')
		;
	}

	public function scopeSortByOutcomescope($query, $direction = null)
	{
		$query->orderBy('outcomescopes.name', $direction)
			->join('outcomescopes', 'outcomes.outcomescope_id', '=', 'outcomescopes.id')
		;
	}

	public function scopeSortByStage($query, $direction = null)
	{
		$query->orderBy('stages.name', $direction)
			->join('matches', 'outcomes.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id');
	}

	public function scopeSortBySeason($query, $direction = null)
	{
		$query->orderBy('seasons.name', $direction)
			->join('matches', 'outcomes.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id')
			->join('seasons', 'stages.season_id', '=', 'seasons.id');
	}

	public function scopeSortByTournament($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction)
			->join('matches', 'outcomes.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id')
			->join('seasons', 'stages.season_id', '=', 'seasons.id')
			->join('tournaments', 'seasons.tournament_id', '=', 'tournaments.id');
	}

	// Sort By Fields

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('outcomes.external_id', $direction);
	}

	// Sort By Counters

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where(function ($query) use ($value) {
				$query
					->whereHas('match', function ($query) use ($value) {
						$query->where('matches.name', 'like', "%{$value}%");
					})
					->orWhereHas('outcometype', function ($query) use ($value) {
						$query->where('outcometypes.name', 'like', "%{$value}%");
					})
					->orWhereHas('outcomesubtype', function ($query) use ($value) {
						$query->where('outcomesubtypes.name', 'like', "%{$value}%");
					})
					->orWhereHas('outcomescope', function ($query) use ($value) {
						$query->where('outcomescopes.name', 'like', "%{$value}%");
					})
				;
			});
	}
}
