<?php

namespace App\Entities;

class StageEntity extends AbstractEntity
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
					return route('office.stage.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.stage.search');

			case 'create':
				if (auth()->user()->can('create', \App\Stage::class))
					return route('office.stage.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldSeason()
	{
		return SeasonEntity::relation($this, $this->record->season);
	}

	public function fieldGender()
	{
		return GenderEntity::relation($this, $this->record->gender);
	}

	public function fieldCountry()
	{
		return CountryEntity::relation($this, $this->record->country);
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
					return route('office.stage.show', $this->record->id);
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

	// Lookup Fields

	public function fieldTournament()
	{
		switch($this->property) {
			case 'value':
				return $this->record->season->tournament->name;

			case 'url':
				if (auth()->user()->can('read', $this->record->season->tournament))
					return route('office.tournament.show', $this->record->season->tournament->id);
				else
					return null;
		}
	}

    // Counters

	public function fieldMatchesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->matches_count;
		}
	}
}
