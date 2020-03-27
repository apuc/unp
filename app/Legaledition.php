<?php

namespace App;

use Moment;
use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;

class Legaledition extends Model
{
	use SortableModel;

	protected $fillable = [
		'legaldocument_id',
		'issued_at',
		'content',
	];

	protected $sortable = [
		'legaldocument',
		'issued_at',
	];

	protected $dates = [
		'issued_at',
	];

	public static $rules = [
		'legaldocument_id'	=> 'required|exists:legaldocuments,id',
		'issued_at'			=> 'required|date|unique_with:legaleditions,legaldocument_id',
		'content'			=> 'required',
	];

	// Incoming Relations

	public function legaldocument()
	{
		return $this->belongsTo('App\Legaldocument');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['legaldocument'])->select('legaleditions.*');
	}

	// Sort By Relations

	public function scopeSortByLegaldocument($query, $direction = null)
	{
		$query->orderBy('legaldocuments.name', $direction)
			->join('legaldocuments', 'legaleditions.legaldocument_id', '=', 'legaldocuments.id');
	}

	// Sort By Fields

	public function scopeSortByIssuedAt($query, $direction = null)
	{
		$query->orderBy('legaleditions.issued_at', $direction);
	}

	// Mutators

	public function setIssuedAtAttribute($value)
	{
		$this->attributes['issued_at'] = \Carbon\Carbon::parse($value);
	}
}
