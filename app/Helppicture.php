<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Helppicture extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'helpquestion_id',
		'name',
		'picture',
	];

	protected $sortable = [
		'helpquestion',
		'name',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'helpquestion_id'	=> 'required|exists:helpquestions,id',
		'name' 				=> 'nullable|min:2|max:255',
		'picture'			=> 'required',

	];

	// Incoming Relations

	public function helpquestion()
	{
		return $this->belongsTo('App\Helpquestion');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['helpquestion'])->select('helppictures.*');
	}

	// Sort By Relations

	public function scopeSortByHelpquestion($query, $direction = null)
	{
		$query->orderBy('helpquestions.name', $direction)
			->join('helpquestions', 'helppictures.helpquestion_id', '=', 'helpquestions.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('helppictures.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('helppictures.name', 'like', "%{$value}%");
	}
}
