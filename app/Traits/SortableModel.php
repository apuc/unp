<?php

namespace App\Traits;

trait SortableModel
{
	public function isSortable($field)
	{
		return in_array($field, $this->sortable);
	}

	// Gate Sort

	public function scopeSortBy($query, $field, $direction = null)
	{
		$query->{'sortBy' . studly_case($this->isSortable($field) ? $field : $this->sortable[0])}($direction ?? 'asc');
	}

	// Sort By ID
	public function scopeSortById($query, $direction = null)
	{
		$query->orderBy('id', $direction);	
	}
}
