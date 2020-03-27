<?php

namespace App\Entities;

class DealEntity extends AbstractEntity
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
					return route('office.deal.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.deal.search');

			case 'create':
				if (auth()->user()->can('create', \App\Deal::class))
					return route('office.deal.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldDealtype()
	{
		return DealtypeEntity::relation($this, $this->record->dealtype);
	}

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
					return route('office.deal.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldUrl()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->url;

			case 'control':
				return 'text';
		}
	}

	public function fieldCover()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->cover;

			case 'required':
				return true;

			case 'control':
				return 'picture';
		}
	}

	public function fieldDescription()
	{
		switch($this->property) {
			case 'type':
				return 'html';

			case 'value':
				return $this->record->description;

			case 'control':
				return 'htmleditor';
		}
	}

	public function fieldStartedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->started_at;

			case 'control':
				return 'datetime';
		}
	}

	public function fieldFinishedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->finished_at;

			case 'control':
				return 'datetime';
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
}
