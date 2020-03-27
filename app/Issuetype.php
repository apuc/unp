<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Issuetype extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
	];

	protected $sortable = [
		'name',
		'slug',
		'issues_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:issuetypes,name',
		'slug' => 'required|min:2|max:255|unique:issuetypes,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('issuetypes.*');
	}

	// Outgoing Relations

	public function issues()
	{
		return $this->hasMany('App\Issue');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('issuetypes.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('issuetypes.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByIssuesCount($query, $direction = null)
	{
		$query->orderBy('issues_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('issuetypes.name', 'like', "%{$value}%");
	}
}
