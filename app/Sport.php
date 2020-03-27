<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Sport extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'external_id',
		'external_name',
		'is_enabled',
		'position',
		'has_odds',
		'icon',
	];

	protected $sortable = [
		'name',
		'slug',
		'external_id',
		'external_name',
		'is_enabled',
		'position',
		'has_odds',
		'icon',
		'teams_count',
		'tournamenttypes_count',
		'tournaments_count',
		'posts_count',
		'briefs_count',
		'forecasts_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 			=> 'required|min:2|max:255|unique:sports,name',
		'slug' 			=> 'required|min:2|max:255|unique:sports,slug',
		'is_enabled'	=> 'required|boolean',
		'external_id' 	=> 'required|integer|unique:sports,external_id',
		'external_name' => 'required|min:2|max:255|unique:sports,external_name',
		'position'		=> 'nullable|integer|unique:sports,position',
		'has_odds'		=> 'nullable|boolean',
		'icon'			=> 'nullable|image|max:2048',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('sports.*');
	}

	// Outgoing Relations

	public function teams()
	{
		return $this->hasMany('App\Team');
	}

	public function tournaments()
	{
		return $this->hasMany('App\Tournament');
	}

	public function tournamenttypes()
	{
		return $this->hasMany('App\Tournamenttype');
	}

	public function posts()
	{
		return $this->hasMany('App\Post');
	}

	public function briefs()
	{
		return $this->hasMany('App\Brief');
	}

	public function forecasts()
	{
		return $this->hasMany('App\Forecast');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('sports.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('sports.slug', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('sports.position', $direction);
	}

	public function scopeSortByHasOdds($query, $direction = null)
	{
		$query->orderBy('sports.has_odds', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('sports.external_id', $direction);
	}

	public function scopeSortByExternalName($query, $direction = null)
	{
		$query->orderBy('sports.external_name', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('sports.is_enabled', $direction);
	}

	// Sort By Counters

	public function scopeSortByTeamsCount($query, $direction = null)
	{
		$query->orderBy('teams_count', $direction);
	}

	public function scopeSortByTournamentsCount($query, $direction = null)
	{
		$query->orderBy('tournaments_count', $direction);
	}

	public function scopeSortByTournamenttypesCount($query, $direction = null)
	{
		$query->orderBy('tournamenttypes_count', $direction);
	}

	public function scopeSortByPostsCount($query, $direction = null)
	{
		$query->orderBy('posts_count', $direction);
	}

	public function scopeSortByBriefsCount($query, $direction = null)
	{
		$query->orderBy('briefs_count', $direction);
	}

	public function scopeSortByForecastsCount($query, $direction = null)
	{
		$query->orderBy('forecasts_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('sports.name', 'like', "%{$value}%");
	}
}
