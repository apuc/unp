<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Sitetext extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'sitesection_id',
		'name',
		'slug',
		'title',
		'picture',
		'announce',
		'content',
		'is_enabled',
		'position',
	];

	protected $sortable = [
		'sitesection',
		'name',
		'slug',
		'title',
		'is_enabled',
		'position',
		'sitepictures_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'sitesection_id'	=> 'required|exists:sitesections,id',
		'name' 				=> 'required|min:2|max:255|unique_with:sitetexts,sitesection_id',
		'slug' 				=> 'required|min:2|max:255|unique_with:sitetexts,sitesection_id',
		'picture' 			=> 'nullable',
		'content' 			=> 'required',
		'is_enabled' 		=> 'required|boolean',
		'position' 			=> 'required|integer|unique_with:sitetexts,sitesection_id',
	];

	// Incoming Relations

	public function sitesection()
	{
		return $this->belongsTo('App\Sitesection');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['sitesection'])->select('sitetexts.*');
	}

	// Outgoing Relations

	public function sitepictures()
	{
		return $this->hasMany('App\Sitepicture');
	}

	// Sort By Relations

	public function scopeSortBySitesection($query, $direction = null)
	{
		$query->orderBy('sitesections.name', $direction)
			->join('sitesections', 'sitetexts.sitesection_id', '=', 'sitesections.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('sitetexts.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('sitetexts.slug', $direction);
	}

	public function scopeSortByTitle($query, $direction = null)
	{
		$query->orderBy('sitetexts.title', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('sitetexts.is_enabled', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('sitetexts.position', $direction);
	}

	// Sort By Counters

	public function scopeSortBySitepicturesCount($query, $direction = null)
	{
		$query->orderBy('sitepictures_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('sitetexts.name', 'like', "%{$value}%");
	}
}
