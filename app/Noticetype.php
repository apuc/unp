<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Noticetype extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
	];

	protected $sortable = [
		'name',
		'slug',
		'notices_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:noticetypes,name',
		'slug' => 'required|min:2|max:255|unique:noticetypes,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('noticetypes.*');
	}

	// Outgoing Relations

	public function notices()
	{
		return $this->hasMany('App\Notice');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('noticetypes.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('noticetypes.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByNoticesCount($query, $direction = null)
	{
		$query->orderBy('notices_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('noticetypes.name', 'like', "%{$value}%");
	}
}
