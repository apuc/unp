<?php

namespace App\Entities;

class SitesectionEntity extends AbstractEntity
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
					return route('office.sitesection.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.sitesection.search');

			case 'create':
				if (auth()->user()->can('create', \App\Sitesection::class))
					return route('office.sitesection.create');
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
					return route('office.sitesection.show', $this->record->id);
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

	public function fieldSitetextsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->sitetexts_count;
		}
	}

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
