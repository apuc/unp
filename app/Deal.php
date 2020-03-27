<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Deal extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'dealtype_id',
		'bookmaker_id',
		'name',
		'url',
		'cover',
		'description',
		'started_at',
		'finished_at',
		'seo_title',
		'seo_keywords',
		'seo_description',	
	];

	protected $sortable = [
		'dealtype',
		'bookmaker',
		'name',
		'url',
		'cover',
		'started_at',
		'finished_at',
	];

	protected $filterable = [
		'name',
	];

	protected $dates = [
		'started_at',
		'finished_at',
	];

	public static $rules = [
		'dealtype_id'	=> 'required|exists:dealtypes,id',
		'bookmaker_id'	=> 'required|exists:bookmakers,id',
		'name' 			=> 'required|min:2|max:255|unique_with:deals,bookmaker_id',
		'url' 			=> 'required|min:2|max:255|unique:deals,url',
		'started_at'	=> 'nullable|date',
		'finished_at'	=> 'nullable|date',
	];

	// Incoming Relations

	public function dealtype()
	{
		return $this->belongsTo('App\Dealtype');
	}

	public function bookmaker()
	{
		return $this->belongsTo('App\Bookmaker');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['dealtype', 'bookmaker'])->select('deals.*');
	}

	// Sort By Relations

	public function scopeSortByDealtype($query, $direction = null)
	{
		$query->orderBy('dealtypes.name', $direction)
			->join('dealtypes', 'deals.dealtype_id', '=', 'dealtypes.id');
	}

	public function scopeSortByBookmaker($query, $direction = null)
	{
		$query->orderBy('bookmakers.name', $direction)
			->join('bookmakers', 'deals.bookmaker_id', '=', 'bookmakers.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('deals.name', $direction);
	}

	public function scopeSortByUrl($query, $direction = null)
	{
		$query->orderBy('deals.url', $direction);
	}

	public function scopeSortByStartedAt($query, $direction = null)
	{
		$query->orderBy('deals.started_at', $direction);
	}

	public function scopeSortByFinishedAt($query, $direction = null)
	{
		$query->orderBy('deals.finished_at', $direction);
	}

	public function scopeSortBySeoTitle($query, $direction = null)
	{
		$query->orderBy('deals.seo_title', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('deals.name', 'like', "%{$value}%");
	}

	// Mutators

	public function setStartedAtAttribute($value)
	{
		$this->attributes['started_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}

	public function setFinishedAtAttribute($value)
	{
		$this->attributes['finished_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
	
}
