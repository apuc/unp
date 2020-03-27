<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Action extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'actiongroup_id',
		'name',
		'slug',
		'description',
	];

	protected $sortable = [
		'actiongroup',
		'name',
		'slug',
		'events_count',
		'noticebans_count',
		'noticetemplates_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'actiongroup_id'	=> 'required|exists:actiongroups,id',
		'name' 				=> 'required|min:2|max:255|unique_with:actions,actiongroup_id',
		'slug' 				=> 'required|min:2|max:255|unique_with:actions,actiongroup_id',
	];

	// Incoming Relations

	public function actiongroup()
	{
		return $this->belongsTo('App\Actiongroup');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['actiongroup'])->select('actions.*');
	}

	// Outgoing Relations

	public function events()
	{
		return $this->hasMany('App\Event');
	}

	public function noticebans()
	{
		return $this->hasMany('App\Noticeban');
	}

	public function noticetemplates()
	{
		return $this->hasMany('App\Noticetemplate');
	}

	// Sort By Relations

	public function scopeSortByActiongroup($query, $direction = null)
	{
		$query->orderBy('actiongroups.name', $direction)
			->join('actiongroups', 'actions.actiongroup_id', '=', 'actiongroups.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('actions.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('actions.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByEventsCount($query, $direction = null)
	{
		$query->orderBy('events_count', $direction);
	}

	public function scopeSortByNoticebansCount($query, $direction = null)
	{
		$query->orderBy('noticebans_count', $direction);
	}

	public function scopeSortByNoticetemplatesCount($query, $direction = null)
	{
		$query->orderBy('noticetemplates_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('actions.name', 'like', "%{$value}%");
	}
}
