<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Notice extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'event_id',
		'noticetype_id',
		'noticestatus_id',
		'user_id',
		'message',
		'posted_at',
	];

	protected $sortable = [
		'event',
		'noticetype',
		'noticestatus',
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
		'event_id'			=> 'required|exists:events,id',
		'noticetype_id'		=> 'required|exists:noticetypes,id',
		'noticestatus_id'	=> 'required|exists:noticestatuses,id',
		'user_id'			=> 'required|exists:users,id',
		'message' 			=> 'required',
		'posted_at' 		=> 'required',
	];

	// Incoming Relations

	public function event()
	{
		return $this->belongsTo('App\Event');
	}

	public function noticetype()
	{
		return $this->belongsTo('App\Noticetype');
	}

	public function noticestatus()
	{
		return $this->belongsTo('App\Noticestatus');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['event', 'noticetype', 'noticestatus'])->select('notices.*');
	}

	// Sort By Relations

	public function scopeSortByEvent($query, $direction = null)
	{
		$query->orderBy('events.name', $direction)
			->join('events', 'notices.event_id', '=', 'events.id');
	}

	public function scopeSortByNoticetype($query, $direction = null)
	{
		$query->orderBy('noticetypes.name', $direction)
			->join('noticetypes', 'notices.noticetype_id', '=', 'noticetypes.id');
	}

	public function scopeSortByNoticestatus($query, $direction = null)
	{
		$query->orderBy('noticestatuses.name', $direction)
			->join('noticestatuses', 'notices.noticestatus_id', '=', 'noticestatuses.id');
	}

	// Sort By Fields

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('notices.posted_at', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('notices.name', 'like', "%{$value}%");
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
