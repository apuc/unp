<?php

namespace App\Entities;

class NoticebanEntity extends AbstractEntity
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
					return route('office.noticeban.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.noticeban.search');

			case 'create':
				if (auth()->user()->can('create', \App\Noticeban::class))
					return route('office.noticeban.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldNoticetype()
	{
		return NoticetypeEntity::relation($this, $this->record->noticetype);
	}

	public function fieldAction()
	{
		return ActionEntity::relation($this, $this->record->action);
	}

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
	}
}
