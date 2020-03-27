<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Outcomescope extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'position',
		'description',
		'external_id',
		'external_name',
		'external_description',
		'is_enabled',
	];

	protected $sortable = [
		'name',
		'slug',
		'external_id',
		'external_name',
		'is_enabled',
		'position',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 					=> 'required|min:2|max:255|unique:outcomescopes,name',
		'slug' 					=> 'required|min:2|max:255|unique:outcomescopes,slug',
		'position' 				=> 'required|integer|unique:outcomescopes,position',
		'external_id'			=> 'nullable|integer|unique:outcomescopes,external_id',
		'external_description'	=> 'nullable|max:255',
		'external_name'			=> 'nullable|min:2|max:255|unique:outcomescopes,external_name',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('outcomescopes.*');
	}

	// Outgoing Relations

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('outcomescopes.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('outcomescopes.slug', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('outcomescopes.external_id', $direction);
	}

	public function scopeSortByExternalName($query, $direction = null)
	{
		$query->orderBy('outcomescopes.external_name', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('outcomescopes.is_enabled', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('outcomescopes.position', $direction);
	}

	// Sort By Counters

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('outcomescopes.name', 'like', "%{$value}%");
	}
}
