<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Posttag extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'tag_id',
		'post_id',
	];

	protected $sortable = [
		'tag',
		'post',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'post_id'	=> 'required|exists:posts,id|unique_with:posttags,tag_id',
		'tag_id'	=> 'required|exists:tags,id|unique_with:posttags,post_id',
	];

	// Incoming Relations

	public function tag()
	{
		return $this->belongsTo('App\Tag');
	}

	public function post()
	{
		return $this->belongsTo('App\Post');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['tag', 'post'])->select('posttags.*');
	}


	// Sort By Relations

	public function scopeSortByTag($query, $direction = null)
	{
		$query->orderBy('tags.name', $direction)
			->join('tags', 'posttags.tag_id', '=', 'tags.id');
	}

	public function scopeSortByPost($query, $direction = null)
	{
		$query->orderBy('posts.name', $direction)
			->join('posts', 'posttags.post_id', '=', 'posts.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('posttags.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('posttags.name', 'like', "%{$value}%");
	}
}
