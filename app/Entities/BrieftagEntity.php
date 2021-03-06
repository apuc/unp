<?php

namespace App\Entities;

class BrieftagEntity extends AbstractEntity
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
					return route('office.brieftag.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.brieftag.search');

			case 'create':
				if (auth()->user()->can('create', \App\Brieftag::class))
					return route('office.brieftag.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldTag()
	{
		return TagEntity::relation($this, $this->record->tag);
	}

	public function fieldBrief()
	{
		return BriefEntity::relation($this, $this->record->brief);
	}
}
