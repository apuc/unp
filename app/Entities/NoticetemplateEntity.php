<?php

namespace App\Entities;

class NoticetemplateEntity extends AbstractEntity
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
					return route('office.noticetemplate.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.noticetemplate.search');

			case 'create':
				if (auth()->user()->can('create', \App\Noticetemplate::class))
					return route('office.noticetemplate.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldAction()
	{
		return ActionEntity::relation($this, $this->record->action);
	}

	public function fieldNoticetype()
	{
		return NoticetypeEntity::relation($this, $this->record->noticetype);
	}

	public function fieldRole()
	{
		return RoleEntity::relation($this, $this->record->role);
	}

	// Fields

	public function fieldMessage()
	{
		switch($this->property) {
			case 'type':
				return 'string';

			case 'value':
				return $this->record->message;

			case 'control':
				return 'textarea';
		}
	}
}
