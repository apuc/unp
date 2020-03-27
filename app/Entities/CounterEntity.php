<?php

namespace App\Entities;

class CounterEntity extends AbstractEntity
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
					return route('office.counter.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.counter.search');

			case 'create':
				if (auth()->user()->can('create', \App\Counter::class))
					return route('office.counter.create');
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
					return route('office.counter.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldCodeHead()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->code_head;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldCodeTop()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->code_top;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldCodeFooter()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->code_footer;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldCodeScript()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->code_script;

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
}
