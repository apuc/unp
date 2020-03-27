<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Country extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'flag',
		'is_enabled',
		'external_id',
		'external_name',
	];

	protected $sortable = [
		'name',
		'slug',
		'is_enabled',
		'external_id',
		'external_name',
		'teams_count',
		'stages_count',
	];

	protected $filterable = [
		'name',
		'slug',
		'is_enabled',
		'external',
		'external_name',
	];

	public static $rules = [
		'name' 			=> 'required|min:2|max:255|unique:countries,name',
		'slug' 			=> 'required|min:2|max:255|unique:countries,slug',
		'flag'			=> 'nullable|image|max:2048',
		'is_enabled' 	=> 'required|boolean',
		'external_id' 	=> 'required|unique:countries,external_id',
		'external_name' => 'required|unique:countries,external_name',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('countries.*');
	}

	// Outgoing Relations

	public function teams()
	{
		return $this->hasMany('App\Team');
	}

	public function stages()
	{
		return $this->hasMany('App\Stage');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('countries.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('countries.slug', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('countries.is_enabled', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('countries.external_id', $direction);
	}

	public function scopeSortByExternalName($query, $direction = null)
	{
		$query->orderBy('countries.external_name', $direction);
	}

	// Sort By Counters

	public function scopeSortByTeamsCount($query, $direction = null)
	{
		$query->orderBy('teams_count', $direction);
	}

	public function scopeSortByStagesCount($query, $direction = null)
	{
		$query->orderBy('stages_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('countries.name', 'like', "%{$value}%");
	}

	public function scopeFilterByExternal($query, $value)
	{
		if (filled($value))
			$query->where('countries.external_id', '=', $value);
	}
}
