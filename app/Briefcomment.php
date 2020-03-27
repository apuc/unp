<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Briefcomment extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'brief_id',
		'user_id',
		'commentstatus_id',
		'posted_at',
		'message',
	];

	protected $sortable = [
		'brief',
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
		'brief_id'			=> 'required|exists:briefs,id',
		'user_id'			=> 'required|exists:users,id',
		'commentstatus_id'	=> 'required|exists:commentstatuses,id',
		'posted_at'			=> 'required|date',
		'message'			=> 'required',
	];

	// Incoming Relations

	public function brief()
	{
		return $this->belongsTo('App\Brief');
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
		$query->with(['brief', 'user', 'commentstatus'])->select('briefcomments.*');
	}

	// Sort By Relations

	public function scopeSortByBrief($query, $direction = null)
	{
		$query->orderBy('briefs.name', $direction)
			->join('briefs', 'briefcomments.brief_id', '=', 'briefs.id');
	}

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'briefcomments.user_id', '=', 'users.id');
	}

	public function scopeSortByCommentstatus($query, $direction = null)
	{
		$query->orderBy('commentstatuses.name', $direction)
			->join('commentstatuses', 'briefcomments.commentstatus_id', '=', 'commentstatuses.id');
	}

	// Sort By Fields

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('briefcomments.posted_at', $direction);
	}

	// Filter

	public function scopeFilterByPostedAt($query, $value)
	{
		if (filled($value))
			$query->where('briefcomments.posted_at', 'like', "%{$value}%");
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
