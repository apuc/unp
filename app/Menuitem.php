<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Menuitem extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'menusection_id',
		'name',
		'url',
		'is_enabled',
		'position',
	];

	protected $sortable = [
		'menusection',
		'name',
		'url',
		'is_enabled',
		'position'
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'menusection_id'	=> 'required|exists:menusections,id',
		'name' 				=> 'required|min:2|max:255|unique_with:menuitems,menusection_id',
		'url' 				=> 'required|unique_with:menuitems,menusection_id',
		'is_enabled'		=> 'required|boolean',
		'position' 			=> 'required|integer|unique_with:menuitems,menusection_id',
	];

	// Incoming Relations

	public function menusection()
	{
		return $this->belongsTo('App\Menusection');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['menusection'])->select('menuitems.*');
	}

	// Sort By Relations

	public function scopeSortByMenusection($query, $direction = null)
	{
		$query->orderBy('menusections.name', $direction)
			->join('menusections', 'menuitems.menusection_id', '=', 'menusections.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('menuitems.name', $direction);
	}

	public function scopeSortByUrl($query, $direction = null)
	{
		$query->orderBy('menuitems.url', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('menuitems.is_enabled', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('menuitems.position', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('menuitems.name', 'like', "%{$value}%");
	}
}
