<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Helpsection extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'icon',
		'announce',
		'text_header',
		'text_footer',
		'is_enabled',
		'seo_title',
		'seo_keywords',
		'seo_description',
	];

	protected $sortable = [
		'name',
		'slug',
		'is_enabled',
		'seo_title',
		'helpquestions_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:helpsections,name',
		'slug' => 'required|min:2|max:255|unique:helpsections,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('helpsections.*');
	}

	// Outgoing Relations

	public function helpquestions()
	{
		return $this->hasMany('App\Helpquestion');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('helpsections.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('helpsections.slug', $direction);
	}

	public function scopeSortByIcon($query, $direction = null)
	{
		$query->orderBy('helpsections.icon', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('helpsections.is_enabled', $direction);
	}

	// Sort By Counters

	public function scopeSortByHelpquestionsCount($query, $direction = null)
	{
		$query->orderBy('helpquestions_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('helpsections.name', 'like', "%{$value}%");
	}
}
