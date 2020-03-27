<?php

namespace App\Entities;

class TournamenttypeEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return $this->record->name;

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.tournamenttype.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.tournamenttype.search');

			case 'create':
				if (auth()->user()->can('create', \App\Tournamenttype::class))
					return route('office.tournamenttype.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldSport()
	{
		return SportEntity::relation($this, $this->record->sport);
	}

	// Fields

	public function fieldName()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->name;

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.tournamenttype.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	// Counters

	public function fieldTournamentsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->tournaments_count;
		}
	}
}
