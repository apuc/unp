<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Post extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'user_id',
		'sport_id',
		'poststatus_id',
		'name',
		'picture',
		'picture_author',
		'announce',
		'content',
		'posted_at',
		'seo_title',
		'seo_keywords',
		'seo_description',
	];

	protected $sortable = [
		'user',
		'sport',
		'poststatus',
		'name',
		'posted_at',
		'picture_author',
		'seo_title',
		'postcomments_count',
		'postpictures_count',
		'posttags_count',
		'posttournaments_count',
	];

	protected $filterable = [
		'name',
		'posted_at',
		'poststatus',
		'sport',
		'user',
	];

	protected $dates = [
		'posted_at',
	];

	public static $rules = [
		'user_id'		=> 'required|exists:users,id',
		'sport_id'		=> 'required|exists:sports,id',
		'poststatus_id'	=> 'required|exists:poststatuses,id',

		'name' 			=> 'required|min:2|max:255|unique:posts,name',
		'posted_at' 	=> 'required',
	];

	// Incoming Relations

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function sport()
	{
		return $this->belongsTo('App\Sport');
	}

	public function poststatus()
	{
		return $this->belongsTo('App\Poststatus');
	}

	// Many To Many Relations

	public function tags()
	{
		return $this->belongsToMany('App\Tag', 'posttags');
	}

	public function tournaments()
	{
		return $this->belongsToMany('App\Tournament', 'posttournaments');
	}

	// Outgoing Relations

	public function postcomments()
	{
		return $this->hasMany('App\Postcomment');
	}

	public function postpictures()
	{
		return $this->hasMany('App\Postpicture');
	}

	public function posttags()
	{
		return $this->hasMany('App\Posttag');
	}

	public function posttournaments()
	{
		return $this->hasMany('App\Posttournament');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['user', 'sport', 'poststatus'])->select('posts.*');
	}

	// Sort By Relations

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'posts.user_id', '=', 'users.id');
	}

	public function scopeSortBySport($query, $direction = null)
	{
		$query->orderBy('sports.name', $direction)
			->join('sports', 'posts.sport_id', '=', 'sports.id');
	}

	public function scopeSortByPoststatus($query, $direction = null)
	{
		$query->orderBy('poststatuses.name', $direction)
			->join('poststatuses', 'posts.poststatus_id', '=', 'poststatuses.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('posts.name', $direction);
	}

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('posts.posted_at', $direction);
	}

	public function scopeSortByPictureAuthor($query, $direction = null)
	{
		$query->orderBy('posts.picture_author', $direction);
	}

	public function scopeSortBySeoTitle($query, $direction = null)
	{
		$query->orderBy('posts.seo_title', $direction);
	}

	// Sort By Counters

	public function scopeSortByPostcommentsCount($query, $direction = null)
	{
		$query->orderBy('postcomments_count', $direction);
	}

	public function scopeSortByPostpicturesCount($query, $direction = null)
	{
		$query->orderBy('postpictures_count', $direction);
	}

	public function scopeSortByPosttagsCount($query, $direction = null)
	{
		$query->orderBy('posttags_count', $direction);
	}

	public function scopeSortByPosttournamentsCount($query, $direction = null)
	{
		$query->orderBy('posttournaments_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('posts.name', 'like', "%{$value}%");
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
