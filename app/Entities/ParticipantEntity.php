<?php

namespace App\Entities;

class ParticipantEntity extends AbstractEntity
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
					return route('office.participant.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.participant.search');

			case 'create':
				if (auth()->user()->can('create', \App\Match::class))
					return route('office.participant.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldTeam()
	{
		return TeamEntity::relation($this, $this->record->team);
	}

	public function fieldMatch()
	{
		return MatchEntity::relation($this, $this->record->match);
	}

	// Fields

	public function fieldScore()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->score;

			case 'control':
				return 'text';
		}
	}

	public function fieldExternalId()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->external_id;

			case 'control':
				return 'text';
		}
	}

	public function fieldPosition()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->position;

			case 'control':
				return 'text';
		}
	}

	// Lookup Fields

	public function fieldStage()
	{
		switch($this->property) {
			case 'value':
				return $this->record->match->stage->name;

			case 'url':
				if (auth()->user()->can('read', $this->record->match->stage))
					return route('office.stage.show', $this->record->match->stage->id);
				else
					return null;
		}
	}

	public function fieldSeason()
	{
		switch($this->property) {
			case 'value':
				return $this->record->match->stage->season->name;

			case 'url':
				if (auth()->user()->can('read', $this->record->match->stage->season))
					return route('office.season.show', $this->record->match->stage->season->id);
				else
					return null;
		}
	}

	public function fieldTournament()
	{
		switch($this->property) {
			case 'value':
				return $this->record->match->stage->season->tournament->name;

			case 'url':
				if (auth()->user()->can('read', $this->record->match->stage->season->tournament))
					return route('office.tournament.show', $this->record->match->stage->season->tournament->id);
				else
					return null;
		}
	}
}
