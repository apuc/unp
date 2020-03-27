<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Poststatus extends Model
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
		'posts_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name'		=> 'required|min:2|max:255|unique:poststatuses,name',
		'slug'		=> 'required|min:2|max:255|unique:poststatuses,slug',
		'color_bg'	=> 'nullable|max:20',
		'color_fg'	=> 'nullable|max:20',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('poststatuses.*');
	}

	// Outgoing Relations

	public function posts()
	{
		return $this->hasMany('App\Post');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('poststatuses.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('poststatuses.slug', $direction);
	}

	public function scopeSortByColorBg($query, $direction = null)
	{
		$query->orderBy('poststatuses.color_bg', $direction);
	}

	public function scopeSortByColorFg($query, $direction = null)
	{
		$query->orderBy('poststatuses.color_fg', $direction);
	}

	// Sort By Counters

	public function scopeSortByPostsCount($query, $direction = null)
	{
		$query->orderBy('posts_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (null !== $value)
			$query->where('poststatuses.name', 'LIKE', "%{$value}%");
	}
}
