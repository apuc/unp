<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Noticestatus extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'color_bg',
		'color_fg',
	];

	protected $sortable = [
		'name',
		'slug',
		'color_bg',
		'color_fg',
		'notices_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name'		=> 'required|min:2|max:255|unique:noticestatuses,name',
		'slug'		=> 'required|min:2|max:255|unique:noticestatuses,slug',
		'color_bg'	=> 'nullable|max:20',
		'color_fg'	=> 'nullable|max:20',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('noticestatuses.*');
	}

	// Outgoing Relations

	public function notices()
	{
		return $this->hasMany('App\Notice');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('noticestatuses.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('noticestatuses.slug', $direction);
	}

	public function scopeSortByColorBg($query, $direction = null)
	{
		$query->orderBy('noticestatuses.color_bg', $direction);
	}

	public function scopeSortByColorFg($query, $direction = null)
	{
		$query->orderBy('noticestatuses.color_fg', $direction);
	}

	// Sort By Counters

	public function scopeSortByNoticesCount($query, $direction = null)
	{
		$query->orderBy('notices_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (null !== $value)
			$query->where('noticestatuses.name', 'LIKE', "%{$value}%");
	}
}
