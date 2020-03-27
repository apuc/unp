<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Brieftournament extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'tournament_id',
		'brief_id',
	];

	protected $sortable = [
		'tournament',
		'brief',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'brief_id'		=> 'required|exists:briefs,id|unique_with:brieftournaments,tournament_id',
		'tournament_id'	=> 'required|exists:tournaments,id|unique_with:brieftournaments,brief_id',
	];

	// Incoming Relations

	public function tournament()
	{
		return $this->belongsTo('App\Tournament');
	}

	public function brief()
	{
		return $this->belongsTo('App\Brief');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['tournament', 'brief'])->select('brieftournaments.*');
	}


	// Sort By Relations

	public function scopeSortByTournament($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction)
			->join('tournaments', 'brieftournaments.tournament_id', '=', 'tournaments.id');
	}

	public function scopeSortByBrief($query, $direction = null)
	{
		$query->orderBy('briefs.name', $direction)
			->join('briefs', 'brieftournaments.brief_id', '=', 'briefs.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('brieftournaments.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('brieftournaments.name', 'like', "%{$value}%");
	}
}
