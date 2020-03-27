<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bannerformat extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'width',
		'height',
	];

	protected $sortable = [
		'name',
		'slug',
		'width',
		'height',
		'banners_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 		=> 'required|min:2|max:255|unique:bannerformats,name',
		'slug' 		=> 'required|min:2|max:255|unique:bannerformats,slug',
		'width'		=> 'required|integer|min:16|max:2048|unique_with:bannerformats,height',
		'height' 	=> 'required|integer|min:16|max:2048|unique_with:bannerformats,width',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('bannerformats.*');
	}

	// Outgoing Relations

	public function banners()
	{
		return $this->hasMany('App\Banner');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('bannerformats.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('bannerformats.slug', $direction);
	}

	public function scopeSortByWidth($query, $direction = null)
	{
		$query->orderBy('bannerformats.width', $direction);
	}

	public function scopeSortByHeight($query, $direction = null)
	{
		$query->orderBy('bannerformats.height', $direction);
	}

	// Sort By Counters

	public function scopeSortByBannersCount($query, $direction = null)
	{
		$query->orderBy('banners_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('bannerformats.name', 'like', "%{$value}%");
	}
}
