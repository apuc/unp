<?php

namespace App\Entities;

class OutcomeEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return trans('option.office.outcome', [
					'match'				=> $this->record->match->name,
					'outcometype'		=> $this->record->outcometype->name,
					'outcomescope'		=> $this->record->outcomescope->name,
					'outcomesubtype'	=> $this->record->outcomesubtype->name,
				]);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.outcome.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.outcome.search');

			case 'create':
				if (auth()->user()->can('create', \App\Outcome::class))
					return route('office.outcome.create');
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

	public function fieldOutcometype()
	{
		return OutcometypeEntity::relation($this, $this->record->outcometype);
	}

	public function fieldOutcomesubtype()
	{
		return OutcomesubtypeEntity::relation($this, $this->record->outcomesubtype);
	}

	public function fieldOutcomescope()
	{
		return OutcomescopeEntity::relation($this, $this->record->outcomescope);
	}

	// Fields

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
