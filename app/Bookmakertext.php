<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bookmakertext extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'bookmaker_id',
		'name',
		'slug',
		'picture',
		'announce',
		'content',
		'is_enabled',
		'seo_title',
		'seo_keywords',
		'seo_description',
	];

	protected $sortable = [
		'bookmaker',
		'name',
		'slug',
		'is_enabled',
		'seo_title',
		'bookmakerpictures_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'bookmaker_id'		=> 'required|exists:bookmakers,id',
		'name' 				=> 'required|min:2|max:255|unique_with:bookmakertexts,bookmaker_id',
		'slug' 				=> 'required|min:2|max:255|unique_with:bookmakertexts,bookmaker_id',
		'picture' 			=> 'nullable',
		'content' 			=> 'required',
		'is_enabled' 		=> 'required|boolean',
		'seo_title' 		=> 'nullable|min:2|max:255',
		'seo_kewords' 		=> 'nullable',
		'seo_description'	=> 'nullable',
	];

	// Incoming Relations

	public function bookmaker()
	{
		return $this->belongsTo('App\Bookmaker');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['bookmaker'])->select('bookmakertexts.*');
	}

	// Outgoing Relations

	public function bookmakerpictures()
	{
		return $this->hasMany('App\Bookmakerpicture');
	}

	// Sort By Relations

	public function scopeSortByBookmaker($query, $direction = null)
	{
		$query->orderBy('bookmakers.name', $direction)
			->join('bookmakers', 'bookmakertexts.bookmaker_id', '=', 'bookmakers.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('bookmakertexts.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('bookmakertexts.slug', $direction);
	}

	public function scopeSortByTitle($query, $direction = null)
	{
		$query->orderBy('bookmakertexts.title', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('bookmakertexts.is_enabled', $direction);
	}

	// Sort By Counters

	public function scopeSortByBookmakerpicturesCount($query, $direction = null)
	{
		$query->orderBy('bookmakerpictures_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('bookmakertexts.name', 'like', "%{$value}%");
	}
}
