<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bookmaker extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'external_id',
		'logo',
		'cover',
		'bonus',
		'announce',
		'description',
		'site',
		'phone',
		'email',
		'address',
		'is_enabled',
		'seo_title',
		'seo_keywords',
		'seo_description',
		'position',
	];

	protected $sortable = [
		'name',
		'slug',
		'external_id',
		'site',
		'bonus',
		'phone',
		'email',
		'is_enabled',
		'forecasts_count',
		'rates_count',
		'deals_count',
		'offers_count',
		'bookmakertexts_count',
		'position',
	];

	protected $filterable = [
		'name',
		'slug',
		'site',
		'phone',
		'email',
		'address',
		'bonus',
		'external',
		'is_enabled',
	];

	public static $rules = [
		'name' 			=> 'required|min:2|max:255|unique:bookmakers,name',
		'slug' 			=> 'required|min:2|max:255|unique:bookmakers,slug',
		'site' 			=> 'nullable|min:2|max:255|unique:bookmakers,site',
		'phone' 		=> 'nullable|mobile_number|unique:bookmakers,phone',
		'bonus' 		=> 'nullable|integer',
		'email' 		=> 'nullable|email|unique:bookmakers,email',
		'address' 		=> 'nullable|min:2|max:255|unique:bookmakers,address',
		'position' 		=> 'required|integer|min:1|unique:bookmakers,position',
		'external_id'	=> 'required|integer|unique:bookmakers,external_id',
		'is_enabled'	=> 'nullable|boolean',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('bookmakers.*');
	}

	// Outgoing Relations

	public function forecasts()
	{
		return $this->hasMany('App\Forecast');
	}

	public function offers()
	{
		return $this->hasMany('App\Offer');
	}

	public function deals()
	{
		return $this->hasMany('App\Deal');
	}

	public function bookmakertexts()
	{
		return $this->hasMany('App\Bookmakertext');
	}

	// Sort By Fields

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('bookmakers.position', $direction);
	}

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('bookmakers.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('bookmakers.slug', $direction);
	}

	public function scopeSortBySite($query, $direction = null)
	{
		$query->orderBy('bookmakers.site', $direction);
	}

	public function scopeSortByBonus($query, $direction = null)
	{
		$query->orderBy('bookmakers.bonus', $direction);
	}

	public function scopeSortByPhone($query, $direction = null)
	{
		$query->orderBy('bookmakers.phone', $direction);
	}

	public function scopeSortByEmail($query, $direction = null)
	{
		$query->orderBy('bookmakers.email', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('bookmakers.external_id', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('bookmakers.is_enabled', $direction);
	}

	// Sort By Counters

	public function scopeSortByForecastsCount($query, $direction = null)
	{
		$query->orderBy('forecasts_count', $direction);
	}

	public function scopeSortByRatesCount($query, $direction = null)
	{
		$query->orderBy('rates_count', $direction);
	}

	public function scopeSortByDealsCount($query, $direction = null)
	{
		$query->orderBy('deals_count', $direction);
	}

	public function scopeSortByBookmakertextsCount($query, $direction = null)
	{
		$query->orderBy('bookmakertexts_count', $direction);
	}

	public function scopeSortByOffersCount($query, $direction = null)
	{
		$query->orderBy('offers_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('bookmakers.name', 'like', "%{$value}%");
	}

	public function scopeFilterByExternal($query, $value)
	{
		if (filled($value))
			$query->where('bookmakers.external_id', '=', $value);
	}
}
