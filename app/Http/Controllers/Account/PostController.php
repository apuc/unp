<?php

namespace App\Http\Controllers\Account;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Account\Post\StoreRequest;
use App\Http\Requests\Account\Post\UpdateRequest;

class PostController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		$posts = \App\Post::query()
			->select('posts.*')
			->with([
				'user',
				'sport',
				'poststatus',
			])
			->withCount([
				'postcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->where('user_id', Auth::user()->id)
			->get()
		;

		return view($this->view, compact(
			'posts'
		));
	}

	/**
	 *
	 *
	 */

	public function show($post_id)
	{
		$post = \App\Post::query()
			->select('posts.*')
			->with([
				'user',
				'sport',
				'poststatus',
			])
			->withCount([
				'postcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->where('user_id', Auth::user()->id)
			->findOrFail($post_id)
		;

		return view($this->view, compact(
			'post'
		));
	}

	/**
	 *
	 *
	 */

	public function edit($post_id)
	{
		$post = \App\Post::query()
			->select('posts.*')
			->with([
				'user',
				'sport',
				'poststatus',
				//'posttags',
			])
			->withCount([
				'postcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->where('user_id', Auth::user()->id)
			->findOrFail($post_id)
		;
		$sports	= \App\Sport::query()
			->where('is_enabled', 1)
			->orderBy('name', 'asc')
			->get()
		;
		//$tags	= \App\Tag::query()
		//	->orderBy('name', 'asc')
		//	->get()
		//;
		$poststatusmoderation = \App\Poststatus::query()
			->where('slug', 'moderation')
			->first()
		;
		$poststatusdraft = \App\Poststatus::query()
			->where('slug', 'draft')
			->first()
		;

		return view($this->view, compact(
			'post',
			'sports',
			//'tags',
			'poststatusmoderation',
			'poststatusdraft'
		));
	}

	/**
	 *
	 *
	 */

	public function update(UpdateRequest $request)
	{
		$post = \App\Post::query()
			->select('posts.*')
			//->with([
			//	'posttags',
			//])
			->where('user_id', Auth::user()->id)
			->findOrFail($request->post_id)
		;

		$old = clone $post;

		$post->sport_id			= $request->sport_id;
		$post->poststatus_id	= $request->poststatus_id;
		$post->name				= $request->name;
		$post->picture_author	= $request->picture_author;
		$post->announce			= $request->announce;
		$post->content			= $request->content;
		$post->posted_at		= now();
		$post->save();

		//$post->posttags()->delete();
		//$posttag = new \App\Posttag;
		//$posttag->post_id	= $post->id;
		//$posttag->tag_id	= $request->tag_id;
		//$posttag->save();

		return redirect()->route('account.post.index');
	}

	/**
	 *
	 *
	 */

	public function create()
	{
		$post	= new \App\Post;
		$sports	= \App\Sport::query()
			->where('is_enabled', 1)
			->orderBy('name', 'asc')
			->get()
		;
		//$tags	= \App\Tag::query()
		//	->orderBy('name', 'asc')
		//	->get()
		//;
		$poststatusmoderation = \App\Poststatus::query()
			->where('slug', 'moderation')
			->first()
		;
		$poststatusdraft = \App\Poststatus::query()
			->where('slug', 'draft')
			->first()
		;

		return view($this->view, compact(
			'post',
			'sports',
			//'tags',
			'poststatusmoderation',
			'poststatusdraft'
		));
	}

	/**
	 *
	 *
	 */

	public function store(StoreRequest $request)
	{
		$post = new \App\Post;
		$post->user_id			= Auth::user()->id;
		$post->sport_id			= $request->sport_id;
		$post->poststatus_id	= $request->poststatus_id;
		$post->name				= $request->name;
		$post->picture_author	= $request->picture_author;
		$post->announce			= $request->announce;
		$post->content			= $request->content;
		$post->posted_at		= now();
		$post->save();

		//$posttag = new \App\Posttag;
		//$posttag->post_id	= $post->id;
		//$posttag->tag_id	= $request->tag_id;
		//$posttag->save();

		return redirect()->route('account.post.index');
	}

	/**
	 *
	 *
	 */

	public function destroy($post_id)
	{
		$post = \App\Post::query()
			->select('posts.*')
			->where('user_id', Auth::user()->id)
			->whereHas('poststatus', function ($query) {
				$query->where('slug', 'draft');
			})
			->findOrFail($post_id)
		;

		event(new PostDestroy($post));

		$post->delete();
	}
}
