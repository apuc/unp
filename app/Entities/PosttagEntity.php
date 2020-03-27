<?php

namespace App\Entities;

class PosttagEntity extends AbstractEntity
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
					return route('office.posttag.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.posttag.search');

			case 'create':
				if (auth()->user()->can('create', \App\Posttag::class))
					return route('office.posttag.create');
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

	public function fieldPost()
	{
		return PostEntity::relation($this, $this->record->post);
	}
}
