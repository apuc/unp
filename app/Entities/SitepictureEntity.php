<?php

namespace App\Entities;

class SitepictureEntity extends AbstractEntity
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
					return route('office.sitepicture.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.sitepicture.search');

			case 'create':
				if (auth()->user()->can('create', \App\Sitepicture::class))
					return route('office.sitepicture.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldSitetext()
	{
		return SitetextEntity::relation($this, $this->record->sitetext);
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
					return route('office.sitepicture.show', $this->record->id);
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
