<?php

namespace App\Entities;

class MatchEntity extends AbstractEntity
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
					return route('office.match.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.match.search');

			case 'create':
				if (auth()->user()->can('create', \App\Match::class))
					return route('office.match.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldMatchstatus()
	{
		return MatchstatusEntity::relation($this, $this->record->matchstatus);
	}

	public function fieldStage()
	{
		return StageEntity::relation($this, $this->record->stage);
	}

	public function fieldBookmaker1()
	{
		return BookmakerEntity::relation($this, $this->record->bookmaker1);
	}

	public function fieldBookmakerx()
	{
		return BookmakerEntity::relation($this, $this->record->bookmakerx);
	}

	public function fieldBookmaker2()
	{
		return BookmakerEntity::relation($this, $this->record->bookmaker2);
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
					return route('office.match.show', $this->record->id);
				else
					return null;

			case 'control':
				return 'text';
		}
	}

	public function fieldStartedAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->started_at;

			case 'control':
				return 'datetime';
		}
	}

	public function fieldOdds1Current()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->odds1_current;

			case 'control':
				return 'text';
		}
	}

	public function fieldOdds1Old()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->odds1_old;

			case 'control':
				return 'text';
		}
	}

	public function fieldOddsxCurrent()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->oddsx_current;

			case 'control':
				return 'text';
		}
	}

	public function fieldOddsxOld()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->oddsx_old;

			case 'control':
				return 'text';
		}
	}

	public function fieldOdds2Current()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->odds2_current;

			case 'control':
				return 'text';
		}
	}

	public function fieldOdds2Old()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->odds2_old;

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

	// Counters

	public function fieldParticipantsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->participants_count;
		}
	}

	public function fieldForecastsCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->forecasts_count;
		}
	}

	public function fieldRatesCount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->rates_count;
		}
	}

	// Lookup fields

	public function fieldSeason()
	{
		switch($this->property) {
			case 'value':
				return $this->record->stage->season->name;

			case 'url':
				if (auth()->user()->can('read', $this->record->stage->season))
					return route('office.season.show', $this->record->stage->season->id);
				else
					return null;
		}
	}

	public function fieldTournament()
	{
		switch($this->property) {
			case 'value':
				return $this->record->stage->season->tournament->name;

			case 'url':
				if (auth()->user()->can('read', $this->record->stage->season->tournament))
					return route('office.tournament.show', $this->record->stage->season->tournament->id);
				else
					return null;
		}
	}
}
