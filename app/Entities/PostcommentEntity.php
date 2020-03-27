<?php

namespace App\Entities;

class PostcommentEntity extends AbstractEntity
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
					return route('office.postcomment.show', $this->record->id);
				else
					return null;

			case 'search':
				return route('office.postcomment.search');

			case 'create':
				if (auth()->user()->can('create', \App\Postcomment::class))
					return route('office.postcomment.create');
				else
					return null;

			case 'control':
				return 'search';
		}
	}

	// Relations

	public function fieldPost()
	{
		return PostEntity::relation($this, $this->record->post);
	}

	public function fieldUser()
	{
		return UserEntity::relation($this, $this->record->user);
	}

	public function fieldCommentstatus()
	{
		return CommentstatusEntity::relation($this, $this->record->commentstatus);
	}

	// Fields

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
