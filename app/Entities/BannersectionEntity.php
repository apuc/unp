<?php

namespace App\Entities;

class BannersectionEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return trans('option.office.bannersection', [
					'id'			=> $this->record->id,
					'bannerplace'	=> $this->record->bannerplace->name,
					'sitesection'	=> $this->record->sitesection->name,
				]);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.bannersection.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.bannersection.search');

			case 'create':
				if (auth()->user()->can('create', \App\Bannersection::class))
					return route('office.bannersection.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldBannersection()
	{
		return BannersectionEntity::relation($this, $this->record->bannersection);
	}

	public function fieldBannerplace()
	{
		return BannerplaceEntity::relation($this, $this->record->bannerplace);
	}

	public function fieldSitesection()
	{
		return SitesectionEntity::relation($this, $this->record->sitesection);
	}

	// Counters

	public function fieldBannersectionsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->bannersections_count;
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
