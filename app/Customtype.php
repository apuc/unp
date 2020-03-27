<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Customtype extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
	];

	protected $sortable = [
		'name',
		'slug',
		'customparams_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:customtypes,name',
		'slug' => 'required|min:2|max:255|unique:customtypes,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('customtypes.*');
	}

	// Outgoing Relations

	public function customparams()
	{
		return $this->hasMany('App\Customparam');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('customtypes.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('customtypes.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByCustomparamsCount($query, $direction = null)
	{
		$query->orderBy('customparams_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('customtypes.name', 'like', "%{$value}%");
	}
}
