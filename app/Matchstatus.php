<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Matchstatus extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'color_bg',
		'color_fg',
	];

	protected $sortable = [
		'name',
		'slug',
		'color_bg',
		'color_fg',
		'matches_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name'		=> 'required|min:2|max:255|unique:matchstatuses,name',
		'slug'		=> 'required|min:2|max:255|unique:matchstatuses,slug',
		'color_bg'	=> 'nullable|max:20',
		'color_fg'	=> 'nullable|max:20',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('matchstatuses.*');
	}

	// Outgoing Relations

	public function matches()
	{
		return $this->hasMany('App\Match');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('matchstatuses.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('matchstatuses.slug', $direction);
	}

	public function scopeSortByColorBg($query, $direction = null)
	{
		$query->orderBy('matchstatuses.color_bg', $direction);
	}

	public function scopeSortByColorFg($query, $direction = null)
	{
		$query->orderBy('matchstatuses.color_fg', $direction);
	}

	// Sort By Counters

	public function scopeSortByMatchesCount($query, $direction = null)
	{
		$query->orderBy('matches_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (null !== $value)
			$query->where('matchstatuses.name', 'LIKE', "%{$value}%");
	}
}
