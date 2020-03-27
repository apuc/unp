<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bannersection extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'bannersection_id',
		'bannerplace_id',
		'sitesection_id',
	];

	protected $sortable = [
		'bannersection',
		'bannerplace',
		'sitesection',
		'bannersections_count',
		'bannerposts_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'bannersection_id'	=> 'nullable|exists:bannersections,id',
		'bannerplace_id'	=> 'required|exists:bannerplaces,id',
		'sitesection_id'	=> 'required|exists:sitesections,id|unique_with:bannersections,bannerplace_id',
	];

	// Incoming Relations

	public function bannersection()
	{
		return $this->belongsTo('App\Bannersection');
	}

	public function bannerplace()
	{
		return $this->belongsTo('App\Bannerplace');
	}

	public function sitesection()
	{
		return $this->belongsTo('App\Sitesection');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['bannersection', 'bannerplace', 'sitesection'])->select('bannersections.*');
	}

	// Outgoing Relations

	public function bannersections()
	{
		return $this->hasMany('App\Bannersection');
	}

	public function bannerposts()
	{
		return $this->hasMany('App\Bannerpost');
	}

	// Sort By Relations

	public function scopeSortByBannerplace($query, $direction = null)
	{
		$query->orderBy('bannerplaces.name', $direction)
			->leftJoin('bannerplaces', 'bannersections.bannerplace_id', '=', 'bannerplaces.id');
	}

	public function scopeSortBySitesection($query, $direction = null)
	{
		$query->orderBy('sitesections.name', $direction)
			->leftJoin('sitesections', 'bannersections.sitesection_id', '=', 'sitesections.id');
	}

	// Sort By Fields

	public function scopeSortByBannersection($query, $direction = null)
	{
		$query->orderBy('bannersections.id', $direction);
	}

	// Sort By Counters

	public function scopeSortByBannersectionsCount($query, $direction = null)
	{
		$query->orderBy('bannersections_count', $direction);
	}

	public function scopeSortByBannerpostsCount($query, $direction = null)
	{
		$query->orderBy('bannerposts_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where(function ($query) use ($value) {
				$query->whereHas('bannerplace', function ($query) use ($value) {
					$query->where('bannerplaces.name', 'like', "%{$value}%");
				});

				$query->orWhereHas('sitesection', function ($query) use ($value) {
					$query->where('sitesections.name', 'like', "%{$value}%");
				});
			});
	}
}
