<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Team extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'sport_id',
		'country_id',
		'gender_id',
		'name',
		'external_id',
		'logo',
	];

	protected $sortable = [
		'sport',
		'country',
		'gender',
		'name',
		'external_id',
		'participants_count',
	];

	protected $filterable = [
		'name',
		'sport',
		'gender',
		'external',
		'country',
	];

	public static $rules = [
		'sport_id'		=> 'required|exists:sports,id',
		'country_id'	=> 'required|exists:countries,id',
		'gender_id'		=> 'required|exists:genders,id',
		'name' 			=> 'required|min:2|max:255',
		'logo' 			=> 'nullable',
		'external_id'	=> 'required|integer|unique:teams,external_id',
	];

	// Incoming Relations

	public function sport()
	{
		return $this->belongsTo('App\Sport');
	}

	public function country()
	{
		return $this->belongsTo('App\Country');
	}

	public function gender()
	{
		return $this->belongsTo('App\Gender');
	}

	// Outgoing Relations

	public function matches()
	{
		return $this->hasMany('App\Match');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['sport', 'country'])->select('teams.*');
	}

	// Outgoing Relations

	public function participants()
	{
		return $this->hasMany('App\Participant');
	}

	// Sort By Relations

	public function scopeSortBySport($query, $direction = null)
	{
		$query->orderBy('sports.name', $direction)
			->join('sports', 'teams.sport_id', '=', 'sports.id');
	}

	public function scopeSortByCountry($query, $direction = null)
	{
		$query->orderBy('countries.name', $direction)
			->join('countries', 'teams.country_id', '=', 'countries.id');
	}

	public function scopeSortByGender($query, $direction = null)
	{
		$query->orderBy('genders.name', $direction)
			->join('genders', 'teams.gender_id', '=', 'genders.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('teams.name', $direction);
	}

	public function scopeSortByExternalId($query, $direction = null)
	{
		$query->orderBy('teams.external_id', $direction);
	}

	// Sort By Counters

	public function scopeSortByParticipantsCount($query, $direction = null)
	{
		$query->orderBy('participants_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('teams.name', 'like', "%{$value}%");
	}

	public function scopeFilterByExternal($query, $value)
	{
		if (filled($value))
			$query->where('teams.external_id', '=', $value);
	}
}
