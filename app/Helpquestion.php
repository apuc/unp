<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Helpquestion extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'helpsection_id',
		'name',
		'answer',
		'is_enabled',
	];

	protected $sortable = [
		'name',
		'helpsection',
		'is_enabled',
		'helppictures_count',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'helpsection_id'	=> 'required|exists:helpsections,id',
		'name' 				=> 'required|min:2|max:255|unique_with:helpquestions,helpsection_id',
		'answer' 			=> 'required|min:2',
		'is_enabled' 		=> 'required|boolean',
	];

	// Incoming Relations

	public function helpsection()
	{
		return $this->belongsTo('App\Helpsection');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['helpsection'])->select('helpquestions.*');
	}

	// Outgoing Relations

	public function helppictures()
	{
		return $this->hasMany('App\Helppicture');
	}

	// Sort By Relations

	public function scopeSortByHelpsection($query, $direction = null)
	{
		$query->orderBy('helpsections.name', $direction)
			->join('helpsections', 'helpquestions.helpsection_id', '=', 'helpsections.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('helpquestions.name', $direction);
	}

	public function scopeSortByIsEnabled($query, $direction = null)
	{
		$query->orderBy('helpquestions.is_enabled', $direction);
	}

	// Sort By Counters

	public function scopeSortByHelppicturesCount($query, $direction = null)
	{
		$query->orderBy('helppictures_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('helpquestions.name', 'like', "%{$value}%");
	}
}
