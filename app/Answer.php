<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Answer extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'issue_id',
		'user_id',
		'message',
		'posted_at',
	];

	protected $sortable = [
		'id',
		'issue',
		'user',
		'posted_at',
	];

	protected $filterable = [
		'name',
	];

	protected $dates = [
		'posted_at',
	];

	public static $rules = [
		'issue_id'			=> 'required|exists:issues,id',
		'user_id'			=> 'nullable|exists:users,id',
		'message'			=> 'required',
		'posted_at'			=> 'required|date',
	];

	// Incoming Relations

	public function issue()
	{
		return $this->belongsTo('App\Issue');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['issue', 'user'])->select('answers.*');
	}

	// Sort By Relations

	public function scopeSortByIssue($query, $direction = null)
	{
		$query->orderBy('issues.posted_at', $direction)
			->join('issues', 'answers.issue_id', '=', 'issues.id');
	}

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'answers.user_id', '=', 'users.id');
	}

	// Sort By Fields

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('answers.posted_at', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('answers.name', 'like', "%{$value}%");
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
