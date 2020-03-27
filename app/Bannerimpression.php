<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Bannerimpression extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'bannerpost_id',
		'user_id',
		'impressed_at',
		'ip',
	];

	protected $sortable = [
//		'bannerpost',
		'user',
		'impressed_at',
		'ip',
	];

	protected $filterable = [
		'name',
	];

	protected $dates = [
		'impressed_at',
	];

	public static $rules = [
		'bannerpost_id'	=> 'required|exists:bannerposts,id',
		'user_id'		=> 'required|exists:users,id',
		'impressed_at'	=> 'required|date',
		'ip'			=> 'required',
	];

	// Incoming Relations

	public function bannerpost()
	{
		return $this->belongsTo('App\Bannerpost');
	}

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['bannerpost', 'user'])->select('bannerimpressions.*');
	}

	// Sort By Relations

	public function scopeSortByBannerpost($query, $direction = null)
	{
		$query->orderBy('bannerposts.name', $direction)
			->join('bannerposts', 'bannerimpressions.bannerpost_id', '=', 'bannerposts.id');
	}

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'bannerimpressions.user_id', '=', 'users.id');
	}

	// Sort By Fields

	public function scopeSortByImpressedAt($query, $direction = null)
	{
		$query->orderBy('bannerimpressions.impressed_at', $direction);
	}

	public function scopeSortByIp($query, $direction = null)
	{
		$query->orderBy('bannerimpressions.ip', $direction);
	}

	// Filter

	public function scopeFilterByImpressedAt($query, $value)
	{
		if (filled($value))
			$query->where('bannerimpressions.impressed_at', 'like', "%{$value}%");
	}

	// Mutators

	public function setImpressedAtAttribute($value)
	{
		$this->attributes['impressed_at'] = filled($value) ? \Carbon\Carbon::parse($value) : null;
	}
}
