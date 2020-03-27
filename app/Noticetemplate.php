<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Noticetemplate extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'action_id',
		'noticetype_id',
		'role_id',
		'message',
	];

	protected $sortable = [
		'action',
		'noticetype',
		'role',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'action_id'		=> 'required|exists:actions,id|unique_with:noticetemplates,noticetype_id,role_id',
		'noticetype_id'	=> 'required|exists:noticetypes,id|unique_with:noticetemplates,action_id,role_id',
		'role_id'		=> 'required|exists:roles,id|unique_with:noticetemplates,action_id,noticetype_id',
		'message'		=> 'required',
	];

	// Incoming Relations

	public function action()
	{
		return $this->belongsTo('App\Action');
	}

	public function noticetype()
	{
		return $this->belongsTo('App\Noticetype');
	}

	public function role()
	{
		return $this->belongsTo('App\Role');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['action', 'noticetype', 'role'])->select('noticetemplates.*');
	}

	// Sort By Relations

	public function scopeSortByAction($query, $direction = null)
	{
		$query->orderBy('actions.name', $direction)
			->join('actions', 'noticetemplates.action_id', '=', 'actions.id');
	}

	public function scopeSortByNoticetype($query, $direction = null)
	{
		$query->orderBy('noticetypes.name', $direction)
			->join('noticetypes', 'noticetemplates.noticetype_id', '=', 'noticetypes.id');
	}

	public function scopeSortByRole($query, $direction = null)
	{
		$query->orderBy('roles.name', $direction)
			->join('roles', 'noticetemplates.role_id', '=', 'roles.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('noticetemplates.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('noticetemplates.name', 'like', "%{$value}%");
	}
}
