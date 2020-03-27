<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bannerpost extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'banner_id',
		'sitesection_id',
		'bannerplace_id',
		'margin',
		'started_at',
		'finished_at',
		'view_limit',
		'view_amount',
		'click_limit',
		'click_amount',
		'is_enabled',
		'is_debug',
	];

	protected $sortable = [
		'banner',
		'sitesection',
		'bannerplace',
		'margin',
		'started_at',
		'finished_at',
		'view_limit',
		'view_amount',
		'click_limit',
		'click_amount',
		'is_enabled',
		'is_debug',
	];

	protected $filterable = [
		'name',
	];

	protected $dates = [
		'started_at',
		'finished_at',
	];

	public static $rules = [
		'banner_id'			=> 'required|exists:banners,id',
		'sitesection_id'	=> 'required|exists:sitesections,id',
		'bannerplace_id'	=> 'required|exists:bannerplaces,id',
		'margin'			=> 'nullable|integer',
		'started_at'		=> 'nullable|date',
		'finished_at'		=> 'nullable|date',
		'view_limit'		=> 'nullable|integer',
		'view_amount'		=> 'integer',
		'click_limit'		=> 'nullable|integer',
		'click_amount'		=> 'integer',
		'is_enabled'		=> 'boolean',
		'is_debug'			=> 'boolean',
	];

	// Incoming Relations

	public function banner()
	{
		return $this->belongsTo('App\Banner');
	}

	public function sitesection()
	{
		return $this->belongsTo('App\Sitesection');
	}

	public function bannerplace()
	{
		return $this->belongsTo('App\Bannerplace');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['banner', 'sitesection', 'bannerplace'])->select('bannerposts.*');
	}

	// Outgoing Relations
	// Sort By Relations

	public function scopeSortByBanner($query, $direction = null)
	{
		$query->orderBy('banners.name', $direction)
			->leftJoin('banners', 'bannerposts.banner_id', '=', 'banners.id')
		;
	}

	public function scopeSortBySitesection($query, $direction = null)
	{
		$query->orderBy('sitesections.name', $direction)
			->leftJoin('sitesections', 'bannerposts.sitesection_id', '=', 'sitesections.id')
		;
	}

	public function scopeSortByBannerplace($query, $direction = null)
	{
		$query->orderBy('bannerplaces.name', $direction)
			->leftJoin('bannerplaces', 'bannerposts.bannerplace_id', '=', 'bannerplaces.id')
		;
	}

	// Sort By Fields

	public function scopeSortByMargin($query, $direction = null)
	{
		$query->orderBy('bannerposts.margin', $direction);
	}

	public function scopeSortByStartedAt($query, $direction = null)
	{
		$query->orderBy('bannerposts.started_at', $direction);
	}

	public function scopeSortByFinishedAt($query, $direction = null)
	{
		$query->orderBy('bannerposts.finished_at', $direction);
	}

	public function scopeSortByViewLimit($query, $direction = null)
	{
		$query->orderBy('bannerposts.view_limit', $direction);
	}

	public function scopeSortByViewAmount($query, $direction = null)
	{
		$query->orderBy('bannerposts.view_amount', $direction);
	}

	public function scopeSortByClickLimit($query, $direction = null)
	{
		$query->orderBy('bannerposts.click_limit', $direction);
	}

	public function scopeSortByClickAmount($query, $direction = null)
	{
		$query->orderBy('bannerposts.click_amount', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('bannerposts.is_enabled', $direction);
	}

	public function scopeSortByIsDebug($query, $direction = null)
	{
		$query->orderBy('bannerposts.is_debug', $direction);
	}

	// Sort By Counters
	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->whereHas('banner', function ($query) use ($value) {
				$query->where('banners.name', 'like', "%{$value}%");
			});
	}

	// Mutators

	public function setStartedAtAttribute($value)
	{
		$this->attributes['started_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}

	public function setFinishedAtAttribute($value)
	{
		$this->attributes['finished_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
