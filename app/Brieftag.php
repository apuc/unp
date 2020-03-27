<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Brieftag extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'tag_id',
		'brief_id',
	];

	protected $sortable = [
		'tag',
		'brief',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'brief_id'	=> 'required|exists:briefs,id|unique_with:brieftags,tag_id',
		'tag_id'	=> 'required|exists:tags,id|unique_with:brieftags,brief_id',
	];

	// Incoming Relations

	public function tag()
	{
		return $this->belongsTo('App\Tag');
	}

	public function brief()
	{
		return $this->belongsTo('App\Brief');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['tag', 'brief'])->select('brieftags.*');
	}


	// Sort By Relations

	public function scopeSortByTag($query, $direction = null)
	{
		$query->orderBy('tags.name', $direction)
			->join('tags', 'brieftags.tag_id', '=', 'tags.id');
	}

	public function scopeSortByBrief($query, $direction = null)
	{
		$query->orderBy('briefs.name', $direction)
			->join('briefs', 'brieftags.brief_id', '=', 'briefs.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('brieftags.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('brieftags.name', 'like', "%{$value}%");
	}
}
