<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Briefpicture extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'brief_id',
		'name',
		'picture',
	];

	protected $sortable = [
		'brief',
		'name',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'brief_id'	=> 'required|exists:briefs,id',
		'name' 		=> 'nullable|min:2|max:255',
		'picture'	=> 'required',
	];

	// Incoming Relations

	public function brief()
	{
		return $this->belongsTo('App\Brief');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['brief'])->select('briefpictures.*');
	}

	// Sort By Relations

	public function scopeSortByBrief($query, $direction = null)
	{
		$query->orderBy('briefs.name', $direction)
			->join('briefs', 'briefpictures.brief_id', '=', 'briefs.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('briefpictures.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('briefpictures.name', 'like', "%{$value}%");
	}
}
