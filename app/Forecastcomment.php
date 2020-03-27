<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Forecastcomment extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'forecast_id',
		'user_id',
		'commentstatus_id',
		'posted_at',
		'message',
	];

	protected $sortable = [
		'forecast',
		'user',
		'commentstatus',
		'posted_at'
	];

	protected $filterable = [
		'name',
	];

	protected $dates = [
		'posted_at',
	];

	public static $rules = [
		'forecast_id'		=> 'required|exists:forecasts,id',
		'user_id'			=> 'required|exists:users,id',
		'commentstatus_id'	=> 'required|exists:commentstatuses,id',
		'posted_at'			=> 'required|date',
		'message'			=> 'required',
	];

	// Incoming Relations

	public function forecast()
	{
		return $this->belongsTo('App\Forecast');
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
		$query->with(['forecast', 'user', 'commentstatus'])->select('forecastcomments.*');
	}

	// Sort By Relations

	public function scopeSortByForecast($query, $direction = null)
	{
		$query->orderBy('forecasts.posted_at', $direction)
			->join('forecasts', 'forecastcomments.forecast_id', '=', 'forecasts.id');
	}

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'forecastcomments.user_id', '=', 'users.id');
	}

	public function scopeSortByCommentstatus($query, $direction = null)
	{
		$query->orderBy('commentstatuses.name', $direction)
			->join('commentstatuses', 'forecastcomments.commentstatus_id', '=', 'commentstatuses.id');
	}

	// Sort By Fields

	public function scopeSortByPostedAt($query, $direction = null)
	{
		$query->orderBy('forecastcomments.posted_at', $direction);
	}

	// Filter

	public function scopeFilterByPostedAt($query, $value)
	{
		if (filled($value))
			$query->where('forecastcomments.posted_at', 'like', "%{$value}%");
	}

	// Mutators

	public function setPostedAtAttribute($value)
	{
		$this->attributes['posted_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
