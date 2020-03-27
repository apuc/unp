<?php

namespace App\Entities;

class TagEntity extends AbstractEntity
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
					return route('office.tag.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.tag.search');

			case 'create':
				if (auth()->user()->can('create', \App\Tag::class))
					return route('office.tag.create');
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
					return route('office.tag.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	// Counters

	public function fieldPosttagsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->posttags_count;
		}
	}

	public function fieldBrieftagsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->brieftags_count;
		}
	}
}
