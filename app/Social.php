<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Social extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'site',
		'community',
		'icon',
	];

	protected $sortable = [
		'name',
		'slug',
		'site',
		'community',
		'icon',
		'usersocials_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' 		=> 'required|min:2|max:255|unique:socials,name',
		'slug' 		=> 'required|min:2|max:255|unique:socials,slug',
		'site' 		=> 'required|min:2|max:255|unique:socials,site',
		'community' => 'nullable|min:2|max:255|unique:socials,community',
		'icon' 		=> 'required|min:2|max:255|unique:socials,icon',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('socials.*');
	}

	// Outgoing Relations

	public function usersocials()
	{
		return $this->hasMany('App\Usersocial');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('socials.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('socials.slug', $direction);
	}

	public function scopeSortBySite($query, $direction = null)
	{
		$query->orderBy('socials.site', $direction);
	}

	public function scopeSortByCommunity($query, $direction = null)
	{
		$query->orderBy('socials.community', $direction);
	}

	public function scopeSortByIcon($query, $direction = null)
	{
		$query->orderBy('socials.icon', $direction);
	}

	// Sort By Counters

	public function scopeSortByUsersocialsCount($query, $direction = null)
	{
		$query->orderBy('usersocials_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('socials.name', 'like', "%{$value}%");
	}
}
