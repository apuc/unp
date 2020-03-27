<?php

namespace App\Entities;

class TeamEntity extends AbstractEntity
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
					return route('office.team.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.team.search');

			case 'create':
				if (auth()->user()->can('create', \App\Team::class))
					return route('office.team.create');
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

	public function fieldCountry()
	{
		return CountryEntity::relation($this, $this->record->country);
	}

	public function fieldGender()
	{
		return GenderEntity::relation($this, $this->record->gender);
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
					return route('office.team.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldLogo()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->logo;

			case 'required':
				return true;

			case 'control':
				return 'picture';
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

	public function fieldParticipantsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->participants_count;
		}
	}
}
