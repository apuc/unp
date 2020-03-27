<?php

namespace App\Entities;

use Morph;

class BookmakerEntity extends AbstractEntity
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
					return route('office.bookmaker.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.bookmaker.search');

			case 'create':
				if (auth()->user()->can('create', \App\Bookmaker::class))
					return route('office.bookmaker.create');
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
					return route('office.bookmaker.show', $this->record->id);
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

	public function fieldBonus()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->bonus;

			case 'control':
				return 'text';
		}
	}

	public function fieldLogo()
	{
		switch($this->property) {
			case 'type':
				return 'picture';

			case 'value':
				return $this->record->logo;

			case 'required':
				return true;

			case 'control':
				return 'picture';
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

	public function fieldAnnounce()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->announce;

			case 'control':
				return 'textarea';
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

	public function fieldSite()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->site;

			case 'url':
				return $this->record->site;

			case 'control':
				return 'text';
		}
	}


	public function fieldPhone()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return filled($phone = Morph::phone($this->record->phone, '+7 (%d%d%d) %d%d%d-%d%d-%d%d')) ? $phone : null;

			case 'mask':
				return '+7 (000) 000-00-00';

			case 'control':
				return 'text';
		}
	}

	public function fieldEmail()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->email;

			case 'control':
				return 'text';
		}
	}

	public function fieldAddress()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->address;

			case 'control':
				return 'text';
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

	public function fieldPosition()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->position;

			case 'control':
				return 'text';
		}
	}

	public function fieldExternalId()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->external_id;

			case 'control':
				return 'text';
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

	// Counters

	public function fieldForecastsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->forecasts_count;
		}
	}

	public function fieldOffersCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->offers_count;
		}
	}

	public function fieldDealsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->deals_count;
		}
	}

	public function fieldBookmakertextsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->bookmakertexts_count;
		}
	}
}
