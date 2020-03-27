<?php

namespace App\Entities;

class MenusectionEntity extends AbstractEntity
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
					return route('office.menusection.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.menusection.search');

			case 'create':
				if (auth()->user()->can('create', \App\Menusection::class))
					return route('office.menusection.create');
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
					return route('office.menusection.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldUrl()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->url;

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

	public function fieldMenuitemsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->menuitems_count;
		}
	}
}
