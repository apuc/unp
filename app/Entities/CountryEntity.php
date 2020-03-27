<?php

namespace App\Entities;

class CountryEntity extends AbstractEntity
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
					return route('office.country.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.country.search');

			case 'create':
				if (auth()->user()->can('create', \App\Country::class))
					return route('office.country.create');
				else
					return null;

			case 'control':
				return 'search';
		}
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
					return route('office.country.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldSlug()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->slug;

			case 'control':
				return 'text';
		}
	}

	public function fieldIsEnabled()
	{
		switch($this->property) {
			case 'type':
				return 'boolean';

			case 'value':
				return $this->record->is_enabled;

			case 'control':
				return 'checkbox';
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

	public function fieldExternalName()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->external_name;

			case 'control':
				return 'text';
		}
	}

	public function fieldFlag()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->flag;

			case 'required':
				return false;

			case 'control':
				return 'picture';
		}
	}

	// Counters

	public function fieldTeamsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->teams_count;
		}
	}

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
