<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Usersocial extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'user_id',
		'social_id',
		'account',
	];

	protected $sortable = [
		'user',
		'social',
		'account',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'user_id'	=> 'required|exists:users,id|unique_with:usersocials,social_id',
		'social_id'	=> 'required|exists:socials,id|unique_with:usersocials,user_id',
		'account' 	=> 'required|min:2|max:255',
	];

	// Incoming Relations

	public function user()
	{
		return $this->belongsTo('App\User');
	}

	public function social()
	{
		return $this->belongsTo('App\Social');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['user', 'social'])->select('usersocials.*');
	}

	// Sort By Relations

	public function scopeSortByUser($query, $direction = null)
	{
		$query->orderBy('users.name', $direction)
			->join('users', 'usersocials.user_id', '=', 'users.id');
	}

	public function scopeSortBySocial($query, $direction = null)
	{
		$query->orderBy('socials.name', $direction)
			->join('socials', 'usersocials.social_id', '=', 'socials.id');
	}

	// Sort By Fields

	public function scopeSortByAccount($query, $direction = null)
	{
		$query->orderBy('usersocials.account', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('usersocials.name', 'like', "%{$value}%");
	}
}
