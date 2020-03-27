<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Benefit extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'icon',
		'announce',
		'url',
		'position',
	];

	protected $sortable = [
		'name',
		'slug',
		'url',
		'position',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 		=> 'required|min:2|max:255|unique:benefits,name',
		'slug' 		=> 'required|min:2|max:255|unique:benefits,slug',
		'icon' 		=> 'nullable',
		'url' 		=> 'required|min:2|max:255|unique:benefits,url',
		'position' 	=> 'required|integer|unique:benefits,position',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('benefits.*');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('benefits.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('benefits.slug', $direction);
	}

	public function scopeSortByUrl($query, $direction = null)
	{
		$query->orderBy('benefits.url', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('benefits.position', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('benefits.name', 'like', "%{$value}%");
	}
}
