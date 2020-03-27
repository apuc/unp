<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Noticeban extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'noticetype_id',
		'action_id',
		'user_id',
	];

	protected $sortable = [
		'noticetype',
		'action',
		'user',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'noticetype_id'	=> 'required|exists:noticetypes,id|unique_with:noticebans,action_id,user_id',
		'action_id'		=> 'required|exists:actions,id|unique_with:noticebans,noticetype_id,user_id',
		'user_id'		=> 'required|exists:users,id|unique_with:noticebans,action_id,noticetype_id',
	];

	// Incoming Relations

	public function noticetype()
	{
		return $this->belongsTo('App\Noticetype');
	}

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
		$query->with(['noticetype', 'action', 'user'])->select('noticebans.*');
	}

	// Outgoing Relations

	public function noticetypes()
	{
		return $this->hasMany('App\Noticetype');
	}

	public function actions()
	{
		return $this->hasMany('App\Action');
	}

	public function users()
	{
		return $this->hasMany('App\User');
	}

	// Sort By Relations

	public function scopeSortByNoticetype($query, $direction = null)
	{
		$query->orderBy('noticetypes.name', $direction)
			->join('noticetypes', 'noticebans.noticetype_id', '=', 'noticetypes.id');
	}

	public function scopeSortByAction($query, $direction = null)
	{
		$query->orderBy('actions.name', $direction)
			->join('actions', 'noticebans.action_id', '=', 'actions.id');
	}

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'noticebans.user_id', '=', 'users.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('noticebans.name', $direction);
	}

	// Sort By Counters
	/*

	public function scopeSortByNoticetypesCount($query, $direction = null)
	{
		$query->orderBy('noticetypes_count', $direction);
	}

	public function scopeSortByActionsCount($query, $direction = null)
	{
		$query->orderBy('actions_count', $direction);
	}

	public function scopeSortByUsersCount($query, $direction = null)
	{
		$query->orderBy('users_count', $direction);
	}
	*/

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('noticebans.name', 'like', "%{$value}%");
	}
}
