<?php

namespace App\Entities;

class PaymentEntity extends AbstractEntity
{
	public function key()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'id':
				return $this->record->id;

			case 'value':
				return $this->record->id;

			case 'url':
				if (auth()->user()->can('read', $this->record))
					return route('office.payment.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.payment.search');

			case 'create':
				if (auth()->user()->can('create', \App\Payment::class))
					return route('office.payment.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
	}

	// Fields

	public function fieldId()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->id;
		}
	}

	public function fieldAmount()
	{
		switch($this->property) {
			case 'type':
				return 'numeric';

			case 'value':
				return $this->record->amount;

			case 'control':
				return 'text';
		}
	}

	public function fieldPaidAt()
	{
		switch($this->property) {
			case 'type':
				return 'datetime';

			case 'value':
				return $this->record->paid_at;

			case 'control':
				return 'datetime';
		}
	}

	public function fieldPurpose()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->purpose;

			case 'control':
				return 'text';
		}
	}
}
