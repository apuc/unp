<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;

class Counter extends Model
{
	use SortableModel;

	protected $fillable = [
		'name',
		'code_head',
		'code_top',
		'code_footer',
		'code_script',
		'is_enabled',
	];

	protected $sortable = [
		'name',
		'is_enabled',
	];

	public static $rules = [
		'name'        => 'required|min:2|max:255|unique:counters,name',
		'is_enabled'  => 'boolean',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('counters.*');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('counters.name', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('counters.is_enabled', $direction);
	}
}
