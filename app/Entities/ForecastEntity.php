<?php

namespace App\Entities;

class ForecastEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return trans('option.office.forecast', [
					'id'		=> code($this->record->id),
					'posted_at'	=> $this->record->posted_at,
				]);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.forecast.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.forecast.search');

			case 'create':
				if (auth()->user()->can('create', \App\Forecast::class))
					return route('office.forecast.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldSport()
	{
		return SportEntity::relation($this, $this->record->sport);
	}

	public function fieldOutcome()
	{
		return OutcomeEntity::relation($this, $this->record->outcome);
	}

	public function fieldOutcometype()
	{
		return OutcometypeEntity::relation($this, $this->record->outcometype);
	}

	public function fieldOutcomesubtype()
	{
		$value = OutcomesubtypeEntity::relation($this, $this->record->outcomesubtype);

		switch($this->property) {
			case 'value':
				return parse($value, [
					'team' => optional($this->record->team)->name,
				]);

			default:
				return $value;
		}
	}

	public function fieldOutcomescope()
	{
		return OutcomescopeEntity::relation($this, $this->record->outcomescope);
	}

	public function fieldBookmaker()
	{
		return BookmakerEntity::relation($this, $this->record->bookmaker);
	}

	public function fieldMatch()
	{
		return MatchEntity::relation($this, $this->record->match);
	}

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
	}

	public function fieldForecaststatus()
	{
		return ForecaststatusEntity::relation($this, $this->record->forecaststatus);
	}

	// Fields

	public function fieldId()
	{
		switch($this->property) {
			case 'type':
				return 'id';

			case 'value':
				return code($this->record->id);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.forecast.show', $this->record->id);
				else
					return null;
		}
	}

	public function fieldRate()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->rate;

			case 'control':
				return 'text';
		}
	}

	public function fieldBet()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->bet;

			case 'control':
				return 'text';
		}
	}

	public function fieldDescription()
	{
		switch($this->property) {
			case 'type':
				return 'text';

			case 'value':
				return $this->record->description;

			case 'control':
				return 'textarea';
		}
	}

	public function fieldPostedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->posted_at;

			case 'control':
				return 'datetime';
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

	public function fieldStartedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->match->started_at;
		}
	}

	// Counters

	public function fieldForecastcommentsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->forecastcomments_count;
		}
	}

	public function fieldForecastpicturesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->forecastpictures_count;
		}
	}
}
