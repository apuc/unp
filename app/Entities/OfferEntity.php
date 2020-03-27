<?php

namespace App\Entities;

class OfferEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return trans('option.office.offer', [
					'bookmaker'	=> $this->record->bookmaker->name,
					'outcome'	=> $this->record->outcome->name,
				]);

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.offer.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.offer.search');

			case 'create':
				if (auth()->user()->can('create', \App\Offer::class))
					return route('office.offer.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldBookmaker()
	{
		return BookmakerEntity::relation($this, $this->record->bookmaker);
	}

	public function fieldOutcome()
	{
		return OutcomeEntity::relation($this, $this->record->outcome);
	}

	// Fields

	public function fieldOddsCurrent()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->odds_current;

			case 'control':
				return 'text';
		}
	}

	public function fieldOddsOld()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->odds_old;

			case 'control':
				return 'text';
		}
	}

	public function fieldCoupon()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->coupon;

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

	public function fieldHasOffers()
	{
		switch($this->property) {
			case 'type':
				return 'boolean';

			case 'value':
				return $this->record->has_offers;

			case 'control':
				return 'checkbox';
		}
	}
}
