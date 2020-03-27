<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Gender extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
	];

	protected $sortable = [
		'name',
		'slug',
		'tournaments_count',
		'stages_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:genders,name',
		'slug' => 'required|min:2|max:255|unique:genders,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('genders.*');
	}

	// Outgoing Relations

	public function tournaments()
	{
		return $this->hasMany('App\Tournament');
	}

	public function stages()
	{
		return $this->hasMany('App\Stage');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('genders.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('genders.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByTournamentsCount($query, $direction = null)
	{
		$query->orderBy('tournaments_count', $direction);
	}

	public function scopeSortByStagesCount($query, $direction = null)
	{
		$query->orderBy('stages_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('genders.name', 'like', "%{$value}%");
	}
}
