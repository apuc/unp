<?php

namespace App\Entities;

class CustomtypeEntity extends AbstractEntity
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
					return route('office.customtype.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.customtype.search');

			case 'create':
				if (auth()->user()->can('create', \App\Customtype::class))
					return route('office.customtype.create');
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
					return route('office.customtype.show', $this->record->id);
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

	// Counters

	public function fieldCustomparamsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->customparams_count;
		}
	}
}
