<?php

namespace App\Entities;

class UsersocialEntity extends AbstractEntity
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
					return route('office.usersocial.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.usersocial.search');

			case 'create':
				if (auth()->user()->can('create', \App\Usersocial::class))
					return route('office.usersocial.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Fields

	public function fieldAccount()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->account;

			case 'control':
				return 'text';
		}
	}

	// Relations

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
	}

	public function fieldSocial()
	{
		return SocialEntity::relation($this, $this->record->social);
	}
}
