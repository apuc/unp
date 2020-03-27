<?php

namespace App\Entities;

class PostpictureEntity extends AbstractEntity
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
					return route('office.postpicture.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.postpicture.search');

			case 'create':
				if (auth()->user()->can('create', \App\Postpicture::class))
					return route('office.postpicture.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldPost()
	{
		return PostEntity::relation($this, $this->record->post);
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
					return route('office.postpicture.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldPicture()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->picture;

			case 'required':
				return true;

			case 'control':
				return 'picture';
		}
	}
}
