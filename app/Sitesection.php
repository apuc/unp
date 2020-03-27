<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Sitesection extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'seo_title',
		'seo_keywords',
		'seo_description',
	];

	protected $sortable = [
		'name',
		'slug',
		'seo_title',
		'sitetexts_count',
		'bannerposts_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 			=> 'required|min:2|max:255|unique:sitesections,name',
		'slug' 			=> 'required|min:2|max:255|unique:sitesections,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('sitesections.*');
	}

	// Outgoing Relations

	public function sitetexts()
	{
		return $this->hasMany('App\Sitetext');
	}

	public function bannerposts()
	{
		return $this->hasMany('App\Bannerpost');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('sitesections.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('sitesections.slug', $direction);
	}

	public function scopeSortBySeoTitle($query, $direction = null)
	{
		$query->orderBy('sitesections.seo_title', $direction);
	}

	// Sort By Counters

	public function scopeSortBySitetextsCount($query, $direction = null)
	{
		$query->orderBy('sitetexts_count', $direction);
	}

	public function scopeSortByBannerpostsCount($query, $direction = null)
	{
		$query->orderBy('bannerposts_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('sitesections.name', 'like', "%{$value}%");
	}

	// Actions
	public function scopeSelectBySlug($query, $slug)
	{
		$query->select('sitesections.*')
			->with([
				'sitetexts' => function ($query) {
					$query
						->with(['sitepictures'])
						->where('is_enabled', true)
						->sortBy('position');
				}
			])
			->where('slug', $slug)->toSql();
	}
}
