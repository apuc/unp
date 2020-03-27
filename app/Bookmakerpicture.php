<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bookmakerpicture extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'bookmakertext_id',
		'name',
		'picture',
	];

	protected $sortable = [
		'bookmakertext',
		'name',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'bookmakertext_id'	=> 'required|exists:bookmakertexts,id',
		'name' 				=> 'nullable|min:2|max:255',
		'picture'			=> 'required',
	];

	// Incoming Relations

	public function bookmakertext()
	{
		return $this->belongsTo('App\Bookmakertext');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['bookmakertext'])->select('bookmakerpictures.*');
	}

	// Sort By Relations

	public function scopeSortByBookmakertext($query, $direction = null)
	{
		$query->orderBy('bookmakertexts.name', $direction)
			->join('bookmakertexts', 'bookmakerpictures.bookmakertext_id', '=', 'bookmakertexts.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('bookmakerpictures.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('bookmakerpictures.name', 'like', "%{$value}%");
	}
}
