<?php

namespace App\Entities;

class SocialEntity extends AbstractEntity
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
					return route('office.social.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.social.search');

			case 'create':
				if (auth()->user()->can('create', \App\Social::class))
					return route('office.social.create');
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
					return route('office.social.show', $this->record->id);
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

	public function fieldSite()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->site;

			case 'control':
				return 'text';
		}
	}

	public function fieldCommunity()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->community;

			case 'control':
				return 'text';
		}
	}

	public function fieldIcon()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->icon;

			case 'control':
				return 'text';
		}
	}

	// Counters

	public function fieldUsersocialsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->usersocials_count;
		}
	}
}
