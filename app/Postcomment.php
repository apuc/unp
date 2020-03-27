<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Postcomment extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'post_id',
		'user_id',
		'commentstatus_id',
		'posted_at',
		'message',
	];

	protected $sortable = [
		'post',
		'user',
		'commentstatus',
		'posted_at',
	];

	protected $filterable = [
		'posted_at',
	];

	protected $dates = [
		'posted_at',
	];

	public static $rules = [
		'post_id'			=> 'required|exists:posts,id',
		'user_id'			=> 'required|exists:users,id',
		'commentstatus_id'	=> 'required|exists:commentstatuses,id',
		'posted_at'			=> 'required|date',
		'message'			=> 'required',
	];

	// Incoming Relations

	public function post()
	{
		return $this->belongsTo('App\Post');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function commentstatus()
	{
		return $this->belongsTo('App\Commentstatus');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['post', 'user', 'commentstatus'])->select('postcomments.*');
	}

	// Sort By Relations

	public function scopeSortByPost($query, $direction = null)
	{
		$query->orderBy('posts.name', $direction)
			->join('posts', 'postcomments.post_id', '=', 'posts.id');
	}

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'postcomments.user_id', '=', 'users.id');
	}

	public function scopeSortByCommentstatus($query, $direction = null)
	{
		$query->orderBy('commentstatuses.name', $direction)
			->join('commentstatuses', 'postcomments.commentstatus_id', '=', 'commentstatuses.id');
	}

	// Sort By Fields

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('postcomments.posted_at', $direction);
	}

	// Filter

	public function scopeFilterByPostedAt($query, $value)
	{
		if (filled($value))
			$query->where('postcomments.posted_at', 'like', "%{$value}%");
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
