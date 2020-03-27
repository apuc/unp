<?php

namespace App\Entities;

class LegaleditionEntity extends AbstractEntity
{
	public function key()
	{
		//
	}

	// Relations

	public function fieldLegaldocument()
	{
		return LegaldocumentEntity::relation($this, $this->record->legaldocument);
	}

	// Fields

	public function fieldIssuedAt()
	{
		switch($this->property) {
			case 'type':
				return 'date';

			case 'value':
				return $this->record->issued_at;

			case 'control':
				return 'date';
		}
	}

	public function fieldContent()
	{
		switch($this->property) {
			case 'type':
				return 'text';

			case 'value':
				return $this->record->content;

			case 'control':
				return 'htmleditor';
		}
	}
}
