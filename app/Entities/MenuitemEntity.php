<?php

namespace App\Entities;

class MenuitemEntity extends AbstractEntity
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
					return route('office.menuitem.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.menuitem.search');

			case 'create':
				if (auth()->user()->can('create', \App\Menuitem::class))
					return route('office.menuitem.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldMenusection()
	{
		return MenusectionEntity::relation($this, $this->record->menusection);
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
					return route('office.menuitem.show', $this->record->id);
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
}
