<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\SortableModel;
use App\Traits\FilterableModel;

class Posttournament extends Model
{
	use SortableModel, FilterableModel;

	protected $fillable = [
		'tournament_id',
		'post_id',
	];

	protected $sortable = [
		'tournament',
		'post',
	];

	protected $filterable = [
		'name',
	];

	public static $rules = [
		'post_id'	=> 'required|exists:posts,id|unique_with:posttournaments,tournament_id',
		'tournament_id'	=> 'required|exists:tournaments,id|unique_with:posttournaments,post_id',
	];

	// Incoming Relations

	public function tournament()
	{
		return $this->belongsTo('App\Tournament');
	}

	public function post()
	{
		return $this->belongsTo('App\Post');
	}

	// Eager Loading

	public function scopeWithRelations($query)
	{
		$query->with(['tournament', 'post'])->select('posttournaments.*');
	}


	// Sort By Relations

	public function scopeSortByTournament($query, $direction = null)
	{
		$query->orderBy('tournaments.name', $direction)
			->join('tournaments', 'posttournaments.tournament_id', '=', 'tournaments.id');
	}

	public function scopeSortByPost($query, $direction = null)
	{
		$query->orderBy('posts.name', $direction)
			->join('posts', 'posttournaments.post_id', '=', 'posts.id');
	}

	// Sort By Fields

	public function scopeSortByName($query, $direction = null)
	{
		$query->orderBy('posttournaments.name', $direction);
	}

	// Filter

	public function scopeFilterByName($query, $value)
	{
		if (filled($value))
			$query->where('posttournaments.name', 'like', "%{$value}%");
	}
}
