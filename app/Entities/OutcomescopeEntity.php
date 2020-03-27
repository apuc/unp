<?php

namespace App\Entities;

class OutcomescopeEntity extends AbstractEntity
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
					return route('office.outcomescope.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.outcomescope.search');

			case 'create':
				if (auth()->user()->can('create', \App\Outcomescope::class))
					return route('office.outcomescope.create');
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
					return route('office.outcomescope.show', $this->record->id);
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

	public function fieldDescription()
	{
		switch($this->property) {
			case 'type':
				return 'html';

			case 'value':
				return $this->record->description;

			case 'control':
				return 'textarea';
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

	public function fieldExternalDescription()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->external_description;

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

	// Counters
}
