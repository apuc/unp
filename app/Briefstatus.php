<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Briefstatus extends Model
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
		'briefs_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name'		=> 'required|min:2|max:255|unique:briefstatuses,name',
		'slug'		=> 'required|min:2|max:255|unique:briefstatuses,slug',
		'color_bg'	=> 'nullable|max:20',
		'color_fg'	=> 'nullable|max:20',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('briefstatuses.*');
	}

	// Outgoing Relations

	public function briefs()
	{
		return $this->hasMany('App\Brief');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('briefstatuses.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('briefstatuses.slug', $direction);
	}

	public function scopeSortByColorBg($query, $direction = null)
	{
		$query->orderBy('briefstatuses.color_bg', $direction);
	}

	public function scopeSortByColorFg($query, $direction = null)
	{
		$query->orderBy('briefstatuses.color_fg', $direction);
	}

	// Sort By Counters

	public function scopeSortByBriefsCount($query, $direction = null)
	{
		$query->orderBy('briefs_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (null !== $value)
			$query->where('briefstatuses.name', 'LIKE', "%{$value}%");
	}
}
