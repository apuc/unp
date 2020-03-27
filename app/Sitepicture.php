<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Sitepicture extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'sitetext_id',
		'name',
		'picture',
	];

	protected $sortable = [
		'sitetext',
		'name',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'sitetext_id'	=> 'required|exists:sitetexts,id',
		'name' 			=> 'nullable|min:2|max:255',
		'picture'		=> 'required',
	];

	// Incoming Relations

	public function sitetext()
	{
		return $this->belongsTo('App\Sitetext');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['sitetext'])->select('sitepictures.*');
	}

	// Sort By Relations

	public function scopeSortBySitetext($query, $direction = null)
	{
		$query->orderBy('sitetexts.name', $direction)
			->join('sitetexts', 'sitepictures.sitetext_id', '=', 'sitetexts.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('sitepictures.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('sitepictures.name', 'like', "%{$value}%");
	}
}
