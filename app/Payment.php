<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Payment extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'user_id',
		'amount',
		'paid_at',
		'purpose',
	];

	protected $sortable = [
		'id',
		'user',
		'amount',
		'paid_at',
		'purpose',
	];

	protected $filterable = [
		'id',
	];

	protected $dates = [
		'paid_at',
	];

	public static $rules = [
		'user_id'	=> 'required|exists:users,id',
		'amount' 	=> 'required|integer',
		'paid_at'	=> 'date',
		'purpose'	=> 'nullable',
	];

	// Incoming Relations

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['user'])->select('payments.*');
	}

	// Sort By Relations

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.login', $direction)
			->join('users', 'payments.user_id', '=', 'users.id');
	}

	// Sort By Fields

	public function scopeSortByAmount($query, $direction = null)
	{
		$query->orderBy('payments.amount', $direction);
	}

	public function scopeSortByPaidAt($query, $direction = null)
	{
		$query->orderBy('payments.paid_at', $direction);
	}

	public function scopeSortByPurpose($query, $direction = null)
	{
		$query->orderBy('payments.purpose', $direction);
	}

	// Filter

	public function scopeFilterById($query, $value)
	{
		if (filled($value))
			$query->where('payments.id', $value);
	}

	// Mutators

	public function setPaidAtAttribute($value)
	{
		$this->attributes['paid_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
