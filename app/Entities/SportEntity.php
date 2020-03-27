<?php

namespace App\Entities;

class SportEntity extends AbstractEntity
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
					return route('office.sport.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.sport.search');

			case 'create':
				if (auth()->user()->can('create', \App\Sport::class))
					return route('office.sport.create');
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
					return route('office.sport.show', $this->record->id);
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

	public function fieldHasOdds()
	{
		switch($this->property) {
			case 'type':
				return 'boolean';

			case 'value':
				return $this->record->has_odds;

			case 'control':
				return 'checkbox';
		}
	}

	public function fieldIcon()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->icon;

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

	public function fieldTournamenttypesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->tournamenttypes_count;
		}
	}

	public function fieldTournamentsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->tournaments_count;
		}
	}

	public function fieldPostsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->posts_count;
		}
	}

	public function fieldBriefsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->briefs_count;
		}
	}

	public function fieldForecastsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->forecasts_count;
		}
	}
}
