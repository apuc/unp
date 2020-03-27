<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Menusection extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'url',
		'is_enabled',
		'position',
	];

	protected $sortable = [
		'name',
		'url',
		'is_enabled',
		'position',
		'menuitems_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 			=> 'required|min:2|max:255|unique:menusections,name',
		'url' 			=> 'nullable|unique:menusections,url',
		'is_enabled'	=> 'required|boolean',
		'position' 		=> 'required|integer|unique:menusections,position',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('menusections.*');
	}

	// Outgoing Relations

	public function menuitems()
	{
		return $this->hasMany('App\Menuitem');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('menusections.name', $direction);
	}

	public function scopeSortByUrl($query, $direction = null)
	{
		$query->orderBy('menusections.url', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('menusections.is_enabled', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('menusections.position', $direction);
	}

	// Sort By Counters

	public function scopeSortByMenuitemsCount($query, $direction = null)
	{
		$query->orderBy('menuitems_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('menusections.name', 'like', "%{$value}%");
	}
}
