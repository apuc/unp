<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Outcometype extends Model
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
		'outcomes_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 					=> 'required|min:2|max:255|unique:outcometypes,name',
		'slug' 					=> 'required|min:2|max:255|unique:outcometypes,slug',
		'position' 				=> 'required|integer|unique:outcometypes,position',
		'external_id'			=> 'nullable|integer|unique:outcometypes,external_id',
		'external_description'	=> 'nullable|max:255',
		'external_name'			=> 'nullable|min:2|max:255|unique:outcometypes,external_name',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('outcometypes.*');
	}

	// Outgoing Relations

	public function outcomes()
	{
		return $this->hasMany('App\Outcome');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('outcometypes.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('outcometypes.slug', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('outcometypes.external_id', $direction);
	}

	public function scopeSortByExternalName($query, $direction = null)
	{
		$query->orderBy('outcometypes.external_name', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('outcometypes.is_enabled', $direction);
	}

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('outcometypes.position', $direction);
	}

	// Sort By Counters

	public function scopeSortByOutcomesCount($query, $direction = null)
	{
		$query->orderBy('outcomes_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('outcometypes.name', 'like', "%{$value}%");
	}
}
