<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Event extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'action_id',
		'user_id',
		'happened_at',
		'visitor',
		'params',
	];

	protected $sortable = [
		'action',
		'user',
		'happened_at',
		'visitor',
		'notices_count',
	];

	protected $filterable = [
		'name',
	];

	protected $dates = [
		'happened_at',
	];

	public static $rules = [
		'action_id'			=> 'required|exists:actions,id',
		'user_id'			=> 'required|exists:users,id',
		'happened_at'		=> 'required|date',
		'visitor'			=> 'required|ip',
		'params'			=> 'nullable|json',
	];                                      

	// Incoming Relations

	public function action()
	{
		return $this->belongsTo('App\Action');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['action', 'user'])->select('events.*');
	}

	// Outgoing Relations

	public function notices()
	{
		return $this->hasMany('App\Notice');
	}

	// Sort By Relations

	public function scopeSortByAction($query, $direction = null)
	{
		$query->orderBy('actions.name', $direction)
			->join('actions', 'events.action_id', '=', 'actions.id');
	}

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'events.user_id', '=', 'users.id');
	}

	// Sort By Fields

	public function scopeSortByHappenedAt($query, $direction = null)
	{
		$query->orderBy('events.happened_at', $direction);
	}

	public function scopeSortByVisitor($query, $direction = null)
	{
		$query->orderBy('events.visitor', $direction);
	}

	// Sort By Counters

	public function scopeSortByNoticesCount($query, $direction = null)
	{
		$query->orderBy('notices_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('events.name', 'like', "%{$value}%");
	}

	// Mutators

	public function setHappenedAtAttribute($value)
	{
		$this->attributes['happened_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
