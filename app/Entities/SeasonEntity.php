<?php

namespace App\Entities;

class SeasonEntity extends AbstractEntity
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
					return route('office.season.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.season.search');

			case 'create':
				if (auth()->user()->can('create', \App\Season::class))
					return route('office.season.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldTournament()
	{
		return TournamentEntity::relation($this, $this->record->tournament);
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
					return route('office.season.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldExternalId()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->external_id;

			case 'control':
				return 'text';
		}
	}

	// Counters

	public function fieldStagesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->stages_count;
		}
	}
}
