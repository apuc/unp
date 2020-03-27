<?php

namespace App\Entities;

class BookmakertextEntity extends AbstractEntity
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
					return route('office.bookmakertext.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.bookmakertext.search');

			case 'create':
				if (auth()->user()->can('create', \App\Bookmakertext::class))
					return route('office.bookmakertext.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldBookmaker()
	{
		return BookmakerEntity::relation($this, $this->record->bookmaker);
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
					return route('office.bookmakertext.show', $this->record->id);
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

	public function fieldAnnounce()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->annunce;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldContent()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->content;

			case 'control':
				return 'htmleditor';
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

	public function fieldSeoTitle()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->seo_title;

			case 'control':
				return 'text';
		}
	}

	public function fieldSeoKeywords()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->seo_keywords;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldSeoDescription()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->seo_description;

			case 'control':
				return 'textarea';
		}
	}

	// Counters

	public function fieldBookmakerpicturesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->bookmakerpictures_count;
		}
	}
}
