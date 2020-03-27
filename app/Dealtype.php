<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Dealtype extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
	];

	protected $sortable = [
		'name',
		'slug',
		'deals_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:dealtypes,name',
		'slug' => 'required|min:2|max:255|unique:dealtypes,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('dealtypes.*');
	}

	// Outgoing Relations

	public function deals()
	{
		return $this->hasMany('App\Deal');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('dealtypes.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('dealtypes.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByDealsCount($query, $direction = null)
	{
		$query->orderBy('deals_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('dealtypes.name', 'like', "%{$value}%");
	}
}
