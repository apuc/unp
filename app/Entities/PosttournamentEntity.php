<?php

namespace App\Entities;

class PosttournamentEntity extends AbstractEntity
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
					return route('office.posttournament.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.posttournament.search');

			case 'create':
				if (auth()->user()->can('create', \App\Posttournament::class))
					return route('office.posttournament.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldTournament()
	{
		return TournamentEntity::relation($this, $this->record->tournament);
	}

	public function fieldPost()
	{
		return PostEntity::relation($this, $this->record->post);
	}
}
