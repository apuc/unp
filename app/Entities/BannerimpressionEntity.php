<?php

namespace App\Entities;

class BannerimpressionEntity extends AbstractEntity
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
					return route('office.bannerimpression.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.bannerimpression.search');

			case 'create':
				if (auth()->user()->can('create', \App\Bannerimpression::class))
					return route('office.bannerimpression.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldBannerpost()
	{
		return BannerpostEntity::relation($this, $this->record->bannerpost);
	}

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
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
					return route('office.bannerimpression.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldImpressedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->impressed_at;

			case 'control':
				return 'datetime';
		}
	}

	public function fieldIp()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->ip;

			case 'control':
				return 'text';
		}
	}
}
