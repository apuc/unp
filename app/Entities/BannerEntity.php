<?php

namespace App\Entities;

class BannerEntity extends AbstractEntity
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
					return route('office.banner.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.banner.search');

			case 'create':
				if (auth()->user()->can('create', \App\Banner::class))
					return route('office.banner.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldBannerformat()
	{
		return BannerformatEntity::relation($this, $this->record->bannerformat);
	}

	public function fieldBannercampaign()
	{
		return BannercampaignEntity::relation($this, $this->record->bannercampaign);
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
					return route('office.banner.show', $this->record->id);
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

	public function fieldLink()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->link;

			case 'control':
				return 'text';
		}
	}

	public function fieldHtml()
	{
		switch($this->property) {
			case 'type':
				return 'text';

			case 'value':
				return $this->record->html;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldAlt()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->alt;

			case 'control':
				return 'text';
		}
	}

	// Counters

	public function fieldBannerpostsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->bannerposts_count;
		}
	}
}
