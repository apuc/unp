<?php

namespace App\Entities;

class NoticeEntity extends AbstractEntity
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
					return route('office.notice.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.notice.search');

			case 'create':
				if (auth()->user()->can('create', \App\Notice::class))
					return route('office.notice.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldEvent()
	{
		return EventEntity::relation($this, $this->record->event);
	}

	public function fieldNoticetype()
	{
		return NoticetypeEntity::relation($this, $this->record->noticetype);
	}

	public function fieldNoticestatus()
	{
		return NoticestatusEntity::relation($this, $this->record->noticestatus);
	}

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
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
}
