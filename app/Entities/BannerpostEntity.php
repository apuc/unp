<?php

namespace App\Entities;

class BannerpostEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return trans('option.office.bannerpost', [
					'sitesection'	=> $this->record->sitesection->id,
					'banner'		=> $this->record->banner->name,
				]);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.bannerpost.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.bannerpost.search');

			case 'create':
				if (auth()->user()->can('create', \App\Bannerpost::class))
					return route('office.bannerpost.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldBanner()
	{
		return BannerEntity::relation($this, $this->record->banner);
	}

	public function fieldSitesection()
	{
		return SitesectionEntity::relation($this, $this->record->sitesection);
	}

	public function fieldBannerplace()
	{
		return BannerplaceEntity::relation($this, $this->record->bannerplace);
	}

	// Fields

	public function fieldMargin()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->margin;

			case 'control':
				return 'text';
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

	public function fieldViewLimit()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->view_limit;

			case 'control':
				return 'text';
		}
	}

	public function fieldViewAmount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->view_amount;

			case 'control':
				return 'text';
		}
	}

	public function fieldClickLimit()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->click_limit;

			case 'control':
				return 'text';
		}
	}

	public function fieldClickAmount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->click_amount;

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

	public function fieldIsDebug()
	{
		switch($this->property) {
			case 'type':
				return 'boolean';

			case 'value':
				return $this->record->is_debug;

			case 'control':
				return 'checkbox';
		}
	}

	// Counters
}
