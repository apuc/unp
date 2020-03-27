<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Forecastpicture extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'forecast_id',
		'name',
		'picture',
	];

	protected $sortable = [
		'forecast',
		'name',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'forecast_id'	=> 'required|exists:forecasts,id',
		'name' 			=> 'nullable|min:2|max:255',
		'picture'		=> 'required',
	];

	// Incoming Relations

	public function forecast()
	{
		return $this->belongsTo('App\Forecast');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['forecast'])->select('forecastpictures.*');
	}

	// Sort By Relations

	public function scopeSortByForecast($query, $direction = null)
	{
		$query->orderBy('forecasts.posted_at', $direction)
			->join('forecasts', 'forecastpictures.forecast_id', '=', 'forecastpictures.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('forecastpictures.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('forecastpictures.name', 'like', "%{$value}%");
	}
}
