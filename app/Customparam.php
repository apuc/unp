<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Customparam extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'customgroup_id',
		'customtype_id',
		'name',
		'slug',
		'value_string',
		'value_integer',
		'value_text',
		'value_float',
		'value_boolean',
	];

	protected $sortable = [
		'customgroup',
		'customtype',
		'name',
		'slug',
		'value_string',
		'value_integer',
		'value_text',
		'value_float',
		'value_boolean',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'customgroup_id'	=> 'required|exists:customgroups,id',
		'customtype_id'		=> 'required|exists:customtypes,id',
		'name' 				=> 'required|min:1|max:255|unique_with:customparams,customparam_id',
		'slug' 				=> 'required|min:1|max:255|unique_with:customparams,customparam_id',
		'value_string'		=> 'nullable|min:1|max:255',
		'value_integer'		=> 'nullable|integer',
		'value_text'		=> 'nullable|min:1|max:65535',
		'value_float'		=> 'nullable|numeric',
		'value_boolean'		=> 'nullable|boolean',
	];

	// Incoming Relations

	public function customgroup()
	{
		return $this->belongsTo('App\Customgroup');
	}

	public function customtype()
	{
		return $this->belongsTo('App\Customtype');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['customgroup', 'customtype'])->select('customparams.*');
	}

	// Sort By Relations

	public function scopeSortByCustomgroup($query, $direction = null)
	{
		$query->orderBy('customgroups.name', $direction)
			->join('customgroups', 'customparams.customgroup_id', '=', 'customgroups.id');
	}

	public function scopeSortByCustomtype($query, $direction = null)
	{
		$query->orderBy('customtypes.name', $direction)
			->join('customtypes', 'customparams.customtype_id', '=', 'customtypes.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('customparams.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('customparams.name', 'like', "%{$value}%");
	}
}
