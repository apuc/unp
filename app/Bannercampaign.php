<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bannercampaign extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
	];

	protected $sortable = [
		'name',
		'banners_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'name' => 'required|min:2|max:255|unique:bannercampaigns,name',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('bannercampaigns.*');
	}

	// Outgoing Relations

	public function banners()
	{
		return $this->hasMany('App\Banner');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('bannercampaigns.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('bannercampaigns.slug', $direction);
	}

	// Sort By Counters

	public function scopeSortByBannersCount($query, $direction = null)
	{
		$query->orderBy('banners_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('bannercampaigns.name', 'like', "%{$value}%");
	}
}
