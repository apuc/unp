<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Banner extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'bannerformat_id',
		'bannercampaign_id',
		'name',
		'picture',
		'link',
		'html',
		'alt',
	];

	protected $sortable = [
		'bannerformat',
		'bannercampaign',
		'name',
		'link',
		'bannerposts_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'bannerformat_id'	=> 'required|exists:bannerformats,id|unique_with:banners,bannercampaign_id,name',
		'bannercampaign_id' => 'required|exists:bannercampaigns,id|unique_with:banners,bannerformat_id,name',
		'name'				=> 'required|min:2|max:255|unique_with:banners,bannerformat_id,bannercampaign_id',
		'picture'			=> 'required',
		'link'				=> 'required|min:2|max:255',
		'html'				=> 'nullable',
		'alt'				=> 'nullable|max:255',
	];

	// Incoming Relations

	public function bannerformat()
	{
		return $this->belongsTo('App\Bannerformat');
	}

	public function bannercampaign()
	{
		return $this->belongsTo('App\Bannercampaign');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['bannerformat', 'bannercampaign'])->select('banners.*');
	}

	// Outgoing Relations

	public function bannerposts()
	{
		return $this->hasMany('App\Bannerpost');
	}

	// Sort By Relations

	public function scopeSortByBannerformat($query, $direction = null)
	{
		$query->orderBy('bannerformats.name', $direction)
			->join('bannerformats', 'banners.bannerformat_id', '=', 'bannerformats.id');
	}

	public function scopeSortByBannercampaign($query, $direction = null)
	{
		$query->orderBy('bannercampaigns.name', $direction)
			->join('bannercampaigns', 'banners.bannercampaign_id', '=', 'bannercampaigns.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('banners.name', $direction);
	}

	public function scopeSortByLink($query, $direction = null)
	{
		$query->orderBy('banners.link', $direction);
	}

	// Sort By Counters

	public function scopeSortByBannerpostsCount($query, $direction = null)
	{
		$query->orderBy('bannerposts_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('banners.name', 'like', "%{$value}%");
	}
}
