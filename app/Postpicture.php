<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Postpicture extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'post_id',
		'name',
		'picture',
	];

	protected $sortable = [
		'post',
		'name',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'post_id'	=> 'required|exists:posts,id',
		'name' 		=> 'nullable|min:2|max:255',
		'picture'	=> 'required',
	];

	// Incoming Relations

	public function post()
	{
		return $this->belongsTo('App\Post');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['post'])->select('postpictures.*');
	}

	// Sort By Relations

	public function scopeSortByPost($query, $direction = null)
	{
		$query->orderBy('posts.name', $direction)
			->join('posts', 'postpictures.post_id', '=', 'posts.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('postpictures.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('postpictures.name', 'like', "%{$value}%");
	}
}
