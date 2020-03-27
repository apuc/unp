<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Tag extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
	];

	protected $sortable = [
		'name',
		'posttags_count',
		'brieftags_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 			=> 'required|min:2|max:255|unique:tags,name',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('tags.*');
	}

	// Outgoing Relations

	public function posttags()
	{
		return $this->hasMany('App\Posttag');
	}

	public function brieftags()
	{
		return $this->hasMany('App\Brieftag');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('tags.name', $direction);
	}

	// Sort By Counters

	public function scopeSortByPosttagsCount($query, $direction = null)
	{
		$query->orderBy('posttags_count', $direction);
	}

	public function scopeSortByBrieftagsCount($query, $direction = null)
	{
		$query->orderBy('brieftags_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('tags.name', 'like', "%{$value}%");
	}
}
