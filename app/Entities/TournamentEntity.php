<?php

namespace App\Entities;

class TournamentEntity extends AbstractEntity
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
					return route('office.tournament.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.tournament.search');

			case 'create':
				if (auth()->user()->can('create', \App\Tournament::class))
					return route('office.tournament.create');
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

	public function fieldGender()
	{
		return GenderEntity::relation($this, $this->record->gender);
	}

	public function fieldTournamenttype()
	{
		return TournamenttypeEntity::relation($this, $this->record->tournamenttype);
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
					return route('office.tournament.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldId()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->id;

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

	public function fieldIsTop()
	{
		switch($this->property) {
			case 'type':
				return 'boolean';

			case 'value':
				return $this->record->is_top;

			case 'control':
				return 'checkbox';
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
				return false;

			case 'control':
				return 'picture';
		}
	}

	public function fieldPosition()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->position;

			case 'control':
				return 'text';
		}
	}

	// Counters

	public function fieldSeasonsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->seasons_count;
		}
	}

	public function fieldTournamentbriefsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->tournamentbriefs_count;
		}
	}

	public function fieldTournamentpostsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->tournamentposts_count;
		}
	}
}
