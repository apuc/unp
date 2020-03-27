<?php

namespace App\Entities;

class CustomparamEntity extends AbstractEntity
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
					return route('office.customparam.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.customparam.search');

			case 'create':
				if (auth()->user()->can('create', \App\Customparam::class))
					return route('office.customparam.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldCustomgroup()
	{
		return CustomgroupEntity::relation($this, $this->record->customgroup);
	}

	public function fieldCustomtype()
	{
		return CustomtypeEntity::relation($this, $this->record->customtype);
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
					return route('office.customparam.show', $this->record->id);
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

	public function fieldValueString()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->value_string;

			case 'control':
				return 'text';
		}
	}

	public function fieldValueInteger()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->value_integer;

			case 'control':
				return 'text';
		}
	}

	public function fieldValueText()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->value_text;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldValueFloat()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->value_float;

			case 'control':
				return 'text';
		}
	}

	public function fieldValueBoolean()
	{
		switch($this->property) {
			case 'type':
				return 'boolean';

			case 'value':
				return $this->record->value_boolean;

			case 'control':
				return 'checkbox';
		}
	}
}
