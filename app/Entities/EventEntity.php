<?php

namespace App\Entities;

class EventEntity extends AbstractEntity
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
					return route('office.event.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.event.search');

			case 'create':
				if (auth()->user()->can('create', \App\Event::class))
					return route('office.event.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldAction()
	{
		return ActionEntity::relation($this, $this->record->action);
	}

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
	}

	// Fields

	public function fieldHappenedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->happened_at;

			case 'control':
				return 'datetime';
		}
	}

	public function fieldVisitor()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->visitor;

			case 'control':
				return 'text';
		}
	}

	public function fieldParams()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->params;

			case 'control':
				return 'textarea';
		}
	}

	// Counters

	public function fieldNoticesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->notices_count;
		}
	}
}
