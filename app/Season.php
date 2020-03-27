<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Season extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'tournament_id',
		'name',
		'external_id',
	];

	protected $sortable = [
		'tournament',
		'name',
		'external_id',
		'stages_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'tournament_id'	=> 'required|exists:tournaments,id',
		'name' 			=> 'required|min:2|max:255|unique_with:seasons,tournament_id',
		'external_id'	=> 'required|integer|unique:seasons,external_id',
	];

	// Incoming Relations

	public function tournament()
	{
		return $this->belongsTo('App\Tournament');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['tournament'])->select('seasons.*');
	}

	// Outgoing Relations

	public function stages()
	{
		return $this->hasMany('App\Stage');
	}

	// Sort By Relations

	public function scopeSortByTournament($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction)
			->join('tournaments', 'seasons.tournament_id', '=', 'tournaments.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('seasons.name', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('seasons.external_id', $direction);
	}

	// Sort By Counters

	public function scopeSortByStagesCount($query, $direction = null)
	{
		$query->orderBy('stages_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('seasons.name', 'like', "%{$value}%");
	}
}
