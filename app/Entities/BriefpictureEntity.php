<?php

namespace App\Entities;

class BriefpictureEntity extends AbstractEntity
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
					return route('office.briefpicture.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.briefpicture.search');

			case 'create':
				if (auth()->user()->can('create', \App\Briefpicture::class))
					return route('office.briefpicture.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldBrief()
	{
		return BriefEntity::relation($this, $this->record->brief);
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
					return route('office.briefpicture.show', $this->record->id);
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
