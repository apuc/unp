<?php

namespace App\Observers;

use App\Post;
use Facades\App\Http\Handlers\UploadHandler as Upload;

class PostObserver
{
	private $fields = [
		'picture',
	];

	public function created(Post $post)
	{
		$this->updateUser($post->user_id);
	}

	public function updated(Post $post)
	{
		// Если пользователь у поста заменен, то пересчитать также и статистику старого пользователя
		if ($post->isDirty('user_id')) {
			$this->updateUser($post->getOriginal('user_id'), true);
			$this->updateUser($post->user_id, true);
		}
	}

	public function saved(Post $post)
	{
		Upload::file($post, $this->fields);
	}

	public function deleted(Post $post)
	{
		Upload::destroy($post, $this->fields);

		$this->updateUser($post->user_id, true);
	}

	private function updateUser($id, $isUpdateComments = false)
	{
		$user = \App\User::findOrFail($id);
		$user->updatePostsStat();

		if ($isUpdateComments)
			$user->updateCommentsStat();

		$user->save();
	}
}