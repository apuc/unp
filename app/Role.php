<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Role extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
	];

	protected $sortable = [
		'name',
		'slug',
		'users_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:roles,name',
		'slug' => 'required|min:2|max:255|unique:roles,slug',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('roles.*');
	}

	// Outgoing Relations

	public function users()
	{
		return $this->hasMany('App\User');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('roles.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('roles.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByUsersCount($query, $direction = null)
	{
		$query->orderBy('users_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('roles.name', 'like', "%{$value}%");
	}
}
