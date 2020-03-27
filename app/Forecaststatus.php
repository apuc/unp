<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Forecaststatus extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'slug',
		'name',
		'color_bg',
		'color_fg',
	];

	protected $sortable = [
		'name',
		'slug',
		'color_bg',
		'color_fg',
		'forecasts_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name'		=> 'required|min:2|max:255|unique:forecaststatuses,name',
		'slug'		=> 'required|min:2|max:255|unique:forecaststatuses,slug',
		'color_bg'	=> 'nullable|max:20',
		'color_fg'	=> 'nullable|max:20',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('forecaststatuses.*');
	}

	// Outgoing Relations

	public function forecasts()
	{
		return $this->hasMany('App\Forecast');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('forecaststatuses.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('forecaststatuses.slug', $direction);
	}

	public function scopeSortByColorBg($query, $direction = null)
	{
		$query->orderBy('forecaststatuses.color_bg', $direction);
	}

	public function scopeSortByColorFg($query, $direction = null)
	{
		$query->orderBy('forecaststatuses.color_fg', $direction);
	}

	// Sort By Counters

	public function scopeSortByForecastsCount($query, $direction = null)
	{
		$query->orderBy('forecasts_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (null !== $value)
			$query->where('forecaststatuses.name', 'LIKE', "%{$value}%");
	}
}
