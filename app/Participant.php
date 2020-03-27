<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Participant extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'team_id',
		'match_id',
		'score',
		'position',
		'external_id',
	];

	protected $sortable = [
		'tournament',
		'season',
		'stage',
		'match',
		'team',
		'score',
		'position',
		'external_id',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'team_id'		=> 'required|exists:teams,id',
		'match_id'		=> 'required|exists:matches,id|unique_with:participants,team_id',
		'score' 		=> 'nullable',
		'position' 		=> 'required|unique_with:participants,match_id',
		'external_id'	=> 'required|integer|unique:participants,external_id',
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

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['team', 'match.stage.season.tournament'])->select('participants.*');
	}

	// Outgoing Relations

	public function participants()
	{
		return $this->hasMany('App\Participant');
	}

	// Sort By Relations

	public function scopeSortByTeam($query, $direction = null)
	{
		$query->orderBy('teams.name', $direction)
			->join('teams', 'participants.team_id', '=', 'teams.id');
	}

	public function scopeSortByMatch($query, $direction = null)
	{
		$query->orderBy('matches.name', $direction)
			->join('matches', 'participants.match_id', '=', 'matches.id');
	}

	public function scopeSortByStage($query, $direction = null)
	{
		$query->orderBy('stages.name', $direction)
			->join('matches', 'participants.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id');
	}

	public function scopeSortBySeason($query, $direction = null)
	{
		$query->orderBy('seasons.name', $direction)
			->join('matches', 'participants.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id')
			->join('seasons', 'stages.season_id', '=', 'seasons.id');
	}

	public function scopeSortByTournament($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction)
			->join('matches', 'participants.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id')
			->join('seasons', 'stages.season_id', '=', 'seasons.id')
			->join('tournaments', 'seasons.tournament_id', '=', 'tournaments.id');
	}

	// Sort By Fields

	public function scopeSortByScore($query, $direction = null)
	{
		$query->orderBy('participants.score', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('participants.position', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('participants.external_id', $direction);
	}

	// Sort By Counters

	public function scopeSortByParticipantsCount($query, $direction = null)
	{
		$query->orderBy('participants_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('participants.name', 'like', "%{$value}%");
	}
}
