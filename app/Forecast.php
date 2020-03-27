<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Forecast extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'sport_id',
		'outcome_id',
		'outcometype_id',
		'outcomescope_id',
		'outcomesubtype_id',
		'team_id',
		'bookmaker_id',
		'match_id',
		'user_id',
		'forecaststatus_id',
		'rate',
		'bet',
		'posted_at',
		'description',
	];

	protected $sortable = [
		'sport',
		'outcome',
		'outcometype',
		'outcomesubtype',
		'outcomescope',
		'bookmaker',
		'tournament',
		'season',
		'stage',
		'match',
		'started_at',
		'user',
		'forecaststatus',
		'rate',
		'bet',
		'posted_at',
		'forecastcomments_count',
		'forecastpictures_count',
	];

	protected $filterable = [
		'id',
		'posted_at',
		'forecaststatus',
		'user',
		'sport',
		'tournament',
		'season',
		'stage',
		'match',
		'started_at',
		'outcometype',
		'outcomesubtype',
		'outcomescope',
		'bookmaker',
		'rate',
		'bet',
	];

	protected $dates = [
		'posted_at',
	];

	public static $rules = [
		'sport_id'			=> 'required|exists:sports,id',
		'outcome_id'		=> 'exists:outcomes,id',
		'outcometype_id'	=> 'required|exists:outcometypes,id',
		'bookmaker_id'		=> 'required|exists:bookmakers,id',
		'match_id'			=> 'required|exists:matches,id|unique_with:forecasts,outcometype_id,user_id',
		'user_id'			=> 'required|exists:users,id',
		'forecaststatus_id'	=> 'required|exists:forecaststatuses,id',
		'rate'				=> 'required|numeric',
		'bet'				=> 'required|integer',
		'posted_at'			=> 'required|date',
		'description'		=> 'nullable',
	];

	// Incoming Relations

	public function sport()
	{
		return $this->belongsTo('App\Sport');
	}

	public function outcome()
	{
		return $this->belongsTo('App\Outcome');
	}

	public function outcometype()
	{
		return $this->belongsTo('App\Outcometype');
	}

	public function outcomescope()
	{
		return $this->belongsTo('App\Outcomescope');
	}

	public function outcomesubtype()
	{
		return $this->belongsTo('App\Outcomesubtype');
	}

	public function team()
	{
		return $this->belongsTo('App\Team');
	}

	public function bookmaker()
	{
		return $this->belongsTo('App\Bookmaker');
	}

	public function match()
	{
		return $this->belongsTo('App\Match');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function forecaststatus()
	{
		return $this->belongsTo('App\Forecaststatus');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with([
			'sport',
			'outcometype',
			'outcomesubtype',
			'outcomescope',
			'outcome.outcometype',
			'outcome.outcomesubtype',
			'outcome.outcomescope',
			'bookmaker',
			'match.stage.season.tournament',
			'user',
			'forecaststatus'
		])->select('forecasts.*');
	}

	// Outgoing Relations

	public function forecastcomments()
	{
		return $this->hasMany('App\Forecastcomment');
	}

	public function forecastpictures()
	{
		return $this->hasMany('App\Forecastpicture');
	}

	// Sort By Relations

	public function scopeSortBySport($query, $direction = null)
	{
		$query->orderBy('sports.name', $direction)
			->join('sports', 'forecasts.sport_id', '=', 'sports.id');
	}

	public function scopeSortByOutcome($query, $direction = null)
	{
		$query->orderBy('outcomes.name', $direction)
			->join('outcomes', 'forecasts.outcome_id', '=', 'outcomes.id');
	}

	public function scopeSortByBookmaker($query, $direction = null)
	{
		$query->orderBy('bookmakers.name', $direction)
			->join('bookmakers', 'forecasts.bookmaker_id', '=', 'bookmakers.id');
	}

	public function scopeSortByMatch($query, $direction = null)
	{
		$query->orderBy('matches.name', $direction)
			->join('matches', 'forecasts.match_id', '=', 'matches.id');
	}

	public function scopeSortByStartedAt($query, $direction = null)
	{
		$query->orderBy('matches.started_at', $direction)
			->join('matches', 'forecasts.match_id', '=', 'matches.id');
	}

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'forecasts.user_id', '=', 'users.id');
	}

	public function scopeSortByForecaststatus($query, $direction = null)
	{
		$query->orderBy('forecaststatuses.name', $direction)
			->join('forecaststatuses', 'forecasts.forecaststatus_id', '=', 'forecaststatuses.id');
	}

	public function scopeSortByStage($query, $direction = null)
	{
		$query->orderBy('stages.name', $direction)
			->join('matches', 'forecasts.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id');
	}

	public function scopeSortBySeason($query, $direction = null)
	{
		$query->orderBy('seasons.name', $direction)
			->join('matches', 'forecasts.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id')
			->join('seasons', 'stages.season_id', '=', 'seasons.id');
	}

	public function scopeSortByTournament($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction)
			->join('matches', 'forecasts.match_id', '=', 'matches.id')
			->join('stages', 'matches.stage_id', '=', 'stages.id')
			->join('seasons', 'stages.season_id', '=', 'seasons.id')
			->join('tournaments', 'seasons.tournament_id', '=', 'tournaments.id');
	}

	public function scopeSortByOutcometype($query, $direction = null)
	{
		$query->orderBy('outcometypes.name', $direction)
			->join('outcometypes', 'forecasts.outcometype_id', '=', 'outcometypes.id');
	}

	public function scopeSortByOutcomesubtype($query, $direction = null)
	{
		$query->orderBy('outcomesubtypes.name', $direction)
			->join('outcomesubtypes', 'forecasts.outcomesubtype_id', '=', 'outcomesubtypes.id');
	}

	public function scopeSortByOutcomescope($query, $direction = null)
	{
		$query->orderBy('outcomescopes.name', $direction)
			->join('outcomescopes', 'forecasts.outcomescope_id', '=', 'outcomescopes.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('forecasts.name', $direction);
	}

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('forecasts.posted_at', $direction);
	}

	// Sort By Counters

	public function scopeSortByForecastcommentsCount($query, $direction = null)
	{
		$query->orderBy('forecastcomments_count', $direction);
	}

	public function scopeSortByForecastpicturesCount($query, $direction = null)
	{
		$query->orderBy('forecastpictures_count', $direction);
	}

	// Filter

	public function scopeFilterById($query, $value)
	{
		if (filled($value))
			$query->where('forecasts.id', '=', $value);
	}

	public function scopeFilterByRate($query, $value)
	{
		if (filled($value))
			$query->where('forecasts.rate', '=', str_replace(',', '.', $value));
	}

	public function scopeFilterByPostedAt($query, $value)
	{
		if (filled($value))
			$query->where('forecasts.posted_at', 'like', "%{$value}%");
	}

	public function scopeFilterByTournament($query, $value)
	{
		if (filled($value))
			$query->whereHas('match.stage.season.tournament', function ($query) use ($value) {
				$query->where('tournaments.name', 'like', "%{$value}%");
			});
	}

	public function scopeFilterBySeason($query, $value)
	{
		if (filled($value))
			$query->whereHas('match.stage.season', function ($query) use ($value) {
				$query->where('seasons.name', 'like', "%{$value}%");
			});
	}

	public function scopeFilterByStage($query, $value)
	{
		if (filled($value))
			$query->whereHas('match.stage', function ($query) use ($value) {
				$query->where('stages.name', 'like', "%{$value}%");
			});
	}

	public function scopeFilterByStartedAt($query, $value)
	{
		if (filled($value)) {
			$query->whereHas('match', function ($query) use ($value) {
				// сбиваем ключи
				$value = [$value[0] ?? null, $value[1] ?? null];

				// если прислана только "от"
				if (
						!date_parse($value[0])['error_count']
					&&	date_parse($value[1])['error_count']
				)
					$query->where("matches.started_at", '>=', \Carbon\Carbon::parse($value[0])->format('Y-m-d H:i:s'));

				// если прислана только "до"
				elseif (
						!date_parse($value[1])['error_count']
					&&	date_parse($value[0])['error_count']
				)
					$query->where("matches.started_at", '<=', \Carbon\Carbon::parse($value[1])->format('Y-m-d H:i:s'));

				// если прислано две даты
				elseif (
						!date_parse($value[0])['error_count']
					&&	!date_parse($value[1])['error_count']
				)
					$query->whereBetween("matches.started_at", [
						\Carbon\Carbon::parse($value[0])->format('Y-m-d H:i:00'),
						\Carbon\Carbon::parse($value[1])->format('Y-m-d H:i:59'),
					]);
			});
		}
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
