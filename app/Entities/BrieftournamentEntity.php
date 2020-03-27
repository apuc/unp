<?php

namespace App\Entities;

class BrieftournamentEntity extends AbstractEntity
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
					return route('office.brieftournament.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.brieftournament.search');

			case 'create':
				if (auth()->user()->can('create', \App\Brieftournament::class))
					return route('office.brieftournament.create');
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

	public function fieldBrief()
	{
		return BriefEntity::relation($this, $this->record->brief);
	}
}
