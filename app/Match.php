<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Match extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'matchstatus_id',
		'stage_id',
		'name',
		'external_id',
		'started_at',

		'odds1_current',
		'odds1_old',
		'oddsx_current',
		'oddsx_old',
		'odds2_current',
		'odds2_old',

		'bookmaker1_id',
		'bookmakerx_id',
		'bookmaker2_id',
	];

	protected $sortable = [
		'matchstatus',
		'stage',
		'season',
		'tournament',
		'name',
		'external_id',
		'started_at',

		'odds1_current',
		'odds1_old',
		'oddsx_current',
		'oddsx_old',
		'odds2_current',
		'odds2_old',

		'bookmaker1',
		'bookmakerx',
		'bookmaker2',

		'participants_count',
		'forecasts_count',
		'rates_count',
	];

	protected $filterable = [
		'name',
	];

	protected $dates = [
		'started_at',
	];

	public static $rules = [
		'matchstatus_id'	=> 'required|exists:matchstatuses,id',
		'stage_id'			=> 'required|exists:stages,id',
		'name' 				=> 'required|min:2|max:255|unique:matches,name',
		'external_id'		=> 'required|integer|unique:matches,external_id',
		'started_at' 		=> 'required|date',

		'odds1_current'		=> 'nullable|numeric',
		'odds1_old'			=> 'nullable|numeric',
		'oddsx_current'		=> 'nullable|numeric',
		'oddsx_old'			=> 'nullable|numeric',
		'odds2_current'		=> 'nullable|numeric',
		'odds2_old'			=> 'nullable|numeric',

		'bookmaker1_id'		=> 'nullable|exists:bookmakers,id',
		'bookmakerx_id'		=> 'nullable|exists:bookmakers,id',
		'bookmaker2_id'		=> 'nullable|exists:bookmakers,id',

	];

	// Incoming Relations

	public function matchstatus()
	{
		return $this->belongsTo('App\Matchstatus');
	}

	public function stage()
	{
		return $this->belongsTo('App\Stage');
	}

	public function bookmaker1()
	{
		return $this->belongsTo('App\Bookmaker');
	}

	public function bookmakerx()
	{
		return $this->belongsTo('App\Bookmaker');
	}

	public function bookmaker2()
	{
		return $this->belongsTo('App\Bookmaker');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['matchstatus', 'stage.season.tournament', 'bookmaker1', 'bookmakerx', 'bookmaker2'])->select('matches.*');
	}

	// Outgoing Relations

	public function participants()
	{
		return $this->hasMany('App\Participant');
	}

	public function forecasts()
	{
		return $this->hasMany('App\Forecast');
	}

	public function outcomes()
	{
		return $this->hasMany('App\Outcome');
	}

	// Sort By Relations

	public function scopeSortByMatchstatus($query, $direction = null)
	{
		$query->orderBy('matchstatuses.name', $direction)
			->join('matchstatuses', 'matches.matchstatus_id', '=', 'matchstatuses.id');
	}

	public function scopeSortByStage($query, $direction = null)
	{
		$query->orderBy('stages.name', $direction)
			->join('stages', 'matches.stage_id', '=', 'stages.id');
	}

	public function scopeSortBySeason($query, $direction = null)
	{
		$query->orderBy('seasons.name', $direction)
			->join('stages', 'matches.stage_id', '=', 'stages.id')
			->join('seasons', 'stages.season_id', '=', 'seasons.id');
	}

	public function scopeSortByTournament($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction)
			->join('stages', 'matches.stage_id', '=', 'stages.id')
			->join('seasons', 'stages.season_id', '=', 'seasons.id')
			->join('tournaments', 'seasons.tournament_id', '=', 'tournaments.id');
	}

	public function scopeSortByBookmaker1($query, $direction = null)
	{
		$query->orderBy('bookmakers.name', $direction)
			->join('bookmakers', 'matches.bookmaker1_id', '=', 'bookmakers.id');
	}

	public function scopeSortByBookmakerx($query, $direction = null)
	{
		$query->orderBy('bookmakers.name', $direction)
			->join('bookmakers', 'matches.bookmakerx_id', '=', 'bookmakers.id');
	}

	public function scopeSortByBookmaker2($query, $direction = null)
	{
		$query->orderBy('bookmakers.name', $direction)
			->join('bookmakers', 'matches.bookmaker2_id', '=', 'bookmakers.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('matches.name', $direction);
	}

	public function scopeSortByStartedAt($query, $direction = null)
	{
		$query->orderBy('matches.started_at', $direction);
	}

	public function scopeSortByOdds1Current($query, $direction = null)
	{
		$query->orderBy('matches.odds1_current', $direction);
	}

	public function scopeSortByOdds1Old($query, $direction = null)
	{
		$query->orderBy('matches.odds1_old', $direction);
	}

	public function scopeSortByOdds2Current($query, $direction = null)
	{
		$query->orderBy('matches.odds2_current', $direction);
	}

	public function scopeSortByOdds2Old($query, $direction = null)
	{
		$query->orderBy('matches.odds2_old', $direction);
	}

	public function scopeSortByOddsxCurrent($query, $direction = null)
	{
		$query->orderBy('matches.oddsx_current', $direction);
	}

	public function scopeSortByOddsxOld($query, $direction = null)
	{
		$query->orderBy('matches.oddsx_old', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('matches.external_id', $direction);
	}

	// Sort By Counters

	public function scopeSortByParticipantsCount($query, $direction = null)
	{
		$query->orderBy('participants_count', $direction);
	}

	public function scopeSortByForecastsCount($query, $direction = null)
	{
		$query->orderBy('forecasts_count', $direction);
	}

	public function scopeSortByRatesCount($query, $direction = null)
	{
		$query->orderBy('rates_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where(function ($query) use ($value) {
				$elements = (str_contains($value, ' ')) ? explode(' ', $value) : array_wrap($value);

				foreach($elements as $element)
					$query->where('matches.name', 'like', "%{$element}%");
			});
	}

	// Mutators

	public function setStartedAtAttribute($value)
	{
		$this->attributes['started_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
