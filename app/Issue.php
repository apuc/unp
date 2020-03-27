<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Issue extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'user_id',
		'issuetype_id',
		'issuestatus_id',
		'author',
		'email',
		'message',
		'posted_at',
	];

	protected $sortable = [
		'id',
		'user',
		'issuetype',
		'issuestatus',
		'author',
		'email',
		'posted_at',
	];

	protected $filterable = [
		'posted_at',
	];

	protected $dates = [
		'posted_at',
	];

	public static $rules = [
		'user_id'			=> 'nullable|exists:users,id',
		'issuetype_id'		=> 'required|exists:issuetypes,id',
		'issuestatus_id'	=> 'required|exists:issuestatuses,id',
		'author' 			=> 'nullable|min:2|max:255',
		'email' 			=> 'nullable|email',
		'message' 			=> 'required',
		'posted_at'			=> 'required|date',
	];

	// Incoming Relations

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function issuetype()
	{
		return $this->belongsTo('App\Issuetype');
	}

	public function issuestatus()
	{
		return $this->belongsTo('App\Issuestatus');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['user', 'issuetype', 'issuestatus'])->select('issues.*');
	}

	// Outgoing Relations

	public function answers()
	{
		return $this->hasMany('App\Answer');
	}

	// Sort By Relations

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'issues.user_id', '=', 'users.id');
	}

	public function scopeSortByIssuetype($query, $direction = null)
	{
		$query->orderBy('issuetypes.name', $direction)
			->join('issuetypes', 'issues.issuetype_id', '=', 'issuetypes.id');
	}

	public function scopeSortByIssuestatus($query, $direction = null)
	{
		$query->orderBy('issuestatuses.name', $direction)
			->join('issuestatuses', 'issues.issuestatus_id', '=', 'issuestatuses.id');
	}

	// Sort By Fields

	public function scopeSortByAuthor($query, $direction = null)
	{
		$query->orderBy('issues.author', $direction);
	}

	public function scopeSortByEmail($query, $direction = null)
	{
		$query->orderBy('issues.email', $direction);
	}

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('issues.posted_at', $direction);
	}

	// Sort By Counters

	public function scopeSortByAnswersCount($query, $direction = null)
	{
		$query->orderBy('answers_count', $direction);
	}

	// Filter

	public function scopeFilterById($query, $value)
	{
		if (filled($value))
			$query->where('issues.id', '=', $value);
	}

	public function scopeFilterByPostedAt($query, $value)
	{
		if (filled($value))
			$query->where('issues.posted_at', 'like', "%{$value}%");
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
