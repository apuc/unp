<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Commentstatus extends Model
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
		'postcomments_count',
		'briefcomments_count',
		'forecastcomments_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name'		=> 'required|min:2|max:255|unique:commentstatuses,name',
		'slug'		=> 'required|min:2|max:255|unique:commentstatuses,slug',
		'color_bg'	=> 'nullable|max:20',
		'color_fg'	=> 'nullable|max:20',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('commentstatuses.*');
	}

	// Outgoing Relations

	public function postcomments()
	{
		return $this->hasMany('App\Postcomment');
	}

	public function briefcomments()
	{
		return $this->hasMany('App\Briefcomment');
	}

	public function forecastcomments()
	{
		return $this->hasMany('App\Forecastcomment');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('commentstatuses.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('commentstatuses.slug', $direction);
	}

	public function scopeSortByColorBg($query, $direction = null)
	{
		$query->orderBy('commentstatuses.color_bg', $direction);
	}

	public function scopeSortByColorFg($query, $direction = null)
	{
		$query->orderBy('commentstatuses.color_fg', $direction);
	}

	// Sort By Counters

	public function scopeSortByBriefcommentsCount($query, $direction = null)
	{
		$query->orderBy('briefcomments_count', $direction);
	}

	public function scopeSortByPostcommentsCount($query, $direction = null)
	{
		$query->orderBy('postcomments_count', $direction);
	}

	public function scopeSortByForecastcommentsCount($query, $direction = null)
	{
		$query->orderBy('forecastcomments_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (null !== $value)
			$query->where('commentstatuses.name', 'LIKE', "%{$value}%");
	}
}
