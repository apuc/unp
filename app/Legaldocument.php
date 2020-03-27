<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Legaldocument extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'name',
		'slug',
		'announce',
		'position',
		'seo_title',
		'seo_keywords',
		'seo_description',
	];

	protected $sortable = [
		'name',
		'slug',
		'position',
		'seo_title',
		'legaleditions_count',
	];

	protected $filterable = [
		'name',
	];

	protected $dates = [
		'issued_at',
	];

	public static $rules = [
		'name'      => 'required|min:2|max:255|unique:legaldocuments,name',
		'slug'      => 'required|min:2|max:255|unique:legaldocuments,slug',
		'position'	=> 'required|integer|unique:legaldocuments,position',
	];

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->select('legaldocuments.*');
	}

	// Outgoing Relations

	public function legaleditions()
	{
		return $this->hasMany('App\Legaledition');
	}

	// Sort By Fields

	public function scopeSortByPosition($query, $direction = null)
	{
		$query->orderBy('legaldocuments.position', $direction);
	}

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('legaldocuments.name', $direction);
	}

	public function scopeSortBySlug($query, $direction = null)
	{
		$query->orderBy('legaldocuments.slug', $direction);
	}

	public function scopeSortBySeoTitle($query, $direction = null)
	{
		$query->orderBy('legaldocuments.seo_title', $direction);
	}

	// Sort By Counters

	public function scopeSortByLegaleditionsCount($query, $direction = null)
	{
		$query->orderBy('legaleditions_count', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('legaldocuments.name', 'LIKE', "%{$value}%");
	}
}
