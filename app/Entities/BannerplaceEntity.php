<?php

namespace App\Entities;

class BannerplaceEntity extends AbstractEntity
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
					return route('office.bannerplace.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.bannerplace.search');

			case 'create':
				if (auth()->user()->can('create', \App\Bannerplace::class))
					return route('office.bannerplace.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations
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
					return route('office.bannerplace.show', $this->record->id);
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