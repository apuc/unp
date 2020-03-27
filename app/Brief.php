<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Brief extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'user_id',
		'sport_id',
		'briefstatus_id',
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
		'briefstatus',
		'name',
		'posted_at',
		'picture_author',
		'seo_title',
		'briefcomments_count',
		'briefpictures_count',
		'brieftags_count',
		'brieftournaments_count',
	];

	protected $filterable = [
		'name',
		'posted_at',
		'briefstatus',
		'sport',
		'user',
	];

	protected $dates = [
		'posted_at',
	];

	public static $rules = [
		'user_id'		=> 'required|exists:users,id',
		'sport_id'		=> 'required|exists:sports,id',
		'briefstatus_id'=> 'required|exists:briefstatuses,id',

		'name' 			=> 'required|min:2|max:255|unique:briefs,name',
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

	public function briefstatus()
	{
		return $this->belongsTo('App\Briefstatus');
	}

	// Many To Many Relations

	public function tags()
	{
		return $this->belongsToMany('App\Tag', 'brieftags');
	}

	public function tournaments()
	{
		return $this->belongsToMany('App\Tournament', 'brieftournaments');
	}

	// Outgoing Relations

	public function briefcomments()
	{
		return $this->hasMany('App\Briefcomment');
	}

	public function briefpictures()
	{
		return $this->hasMany('App\Briefpicture');
	}

	public function brieftags()
	{
		return $this->hasMany('App\Brieftag');
	}

	public function brieftournaments()
	{
		return $this->hasMany('App\Brieftournament');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['user', 'sport', 'briefstatus'])->select('briefs.*');
	}

	// Sort By Relations

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'briefs.user_id', '=', 'users.id');
	}

	public function scopeSortBySport($query, $direction = null)
	{
		$query->orderBy('sports.name', $direction)
			->join('sports', 'briefs.sport_id', '=', 'sports.id');
	}

	public function scopeSortByBriefstatus($query, $direction = null)
	{
		$query->orderBy('briefstatuses.name', $direction)
			->join('briefstatuses', 'briefs.briefstatus_id', '=', 'briefstatuses.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('briefs.name', $direction);
	}

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('briefs.posted_at', $direction);
	}

	public function scopeSortByPictureAuthor($query, $direction = null)
	{
		$query->orderBy('briefs.picture_author', $direction);
	}

	public function scopeSortBySeoTitle($query, $direction = null)
	{
		$query->orderBy('briefs.seo_title', $direction);
	}

	// Sort By Counters

	public function scopeSortByBriefcommentsCount($query, $direction = null)
	{
		$query->orderBy('briefcomments_count', $direction);
	}

	public function scopeSortByBriefpicturesCount($query, $direction = null)
	{
		$query->orderBy('briefpictures_count', $direction);
	}

	public function scopeSortByBrieftagsCount($query, $direction = null)
	{
		$query->orderBy('brieftags_count', $direction);
	}

	public function scopeSortByBrieftournamentsCount($query, $direction = null)
	{
		$query->orderBy('brieftournaments_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('briefs.name', 'like', "%{$value}%");
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
