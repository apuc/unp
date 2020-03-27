<?php

namespace App\Entities;

class ActionEntity extends AbstractEntity
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
					return route('office.action.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.action.search');

			case 'create':
				if (auth()->user()->can('create', \App\Action::class))
					return route('office.action.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldActiongroup()
	{
		return ActiongroupEntity::relation($this, $this->record->actiongroup);
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
					return route('office.action.show', $this->record->id);
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
				return 'string';

			case 'value':
				return $this->record->description;

			case 'control':
				return 'textarea';
		}
	}

	// Counters

	public function fieldEventsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->events_count;
		}
	}

	public function fieldNoticebansCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->noticebans_count;
		}
	}

	public function fieldNoticetemplatesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->noticetemplates_count;
		}
	}
}
