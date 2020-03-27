<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Actiongroup extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
	];

	protected $sortable = [
		'name',
		'slug',
		'actions_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:actiongroups,name',
		'slug' => 'required|min:2|max:255|unique:actiongroups,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('actiongroups.*');
	}

	// Outgoing Relations

	public function actions()
	{
		return $this->hasMany('App\Action');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('actiongroups.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('actiongroups.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByActionsCount($query, $direction = null)
	{
		$query->orderBy('actions_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('actiongroups.name', 'like', "%{$value}%");
	}
}
