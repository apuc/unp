<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bannerplace extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
	];

	protected $sortable = [
		'name',
		'slug',
		'bannerposts_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:bannerplaces,name',
		'slug' => 'required|min:2|max:255|unique:bannerplaces,slug',
	];

	// Incoming Relations
	// Outgoing Relations

	public function bannerposts()
	{
		return $this->hasMany('App\Bannerpost');
	}

	// Eager Loading
	// Sort By Relations
	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('bannerplaces.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('bannerplaces.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByBannerpostsCount($query, $direction = null)
	{
		$query->orderBy('Bannerposts_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('bannerplaces.name', 'like', "%{$value}%");
	}
}
