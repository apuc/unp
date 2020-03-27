<?php

namespace App\Entities;

class BannercampaignEntity extends AbstractEntity
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
					return route('office.bannercampaign.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.bannercampaign.search');

			case 'create':
				if (auth()->user()->can('create', \App\Bannercampaign::class))
					return route('office.bannercampaign.create');
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
					return route('office.bannercampaign.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	// Counters

	public function fieldBannersCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->banners_count;
		}
	}
}
