<?php

namespace App\Http\Controllers\Account;

use Auth;
use Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Requests\Account\Brief\StoreRequest;
use App\Http\Requests\Account\Brief\UpdateRequest;

class BriefController extends Controller
{
	/**
	 *
	 *
	 */

	public function index()
	{
		$briefs = \App\Brief::query()
			->select('briefs.*')
			->with([
				'user',
				'sport',
				'briefstatus',
			])
			->withCount([
				'briefcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->where('user_id', Auth::user()->id)
			->get();

		return view($this->view, compact(
			'briefs'
		));
	}

	/**
	 *
	 *
	 */

	public function show($brief_id)
	{
		$brief = \App\Brief::query()
			->select('briefs.*')
			->with([
				'user',
				'sport',
				'briefstatus',
			])
			->withCount([
				'briefcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->where('user_id', Auth::user()->id)
			->findOrFail($brief_id);

		return view($this->view, compact(
			'brief'
		));
	}

	/**
	 *
	 *
	 */

	public function edit($brief_id)
	{
		$brief = \App\Brief::query()
			->select('briefs.*')
			->with([
				'user',
				'sport',
				'briefstatus',
				//'brieftags',
			])
			->withCount([
				'briefcomments' => function ($query) {
					$query->whereHas('commentstatus', function ($query) {
						$query->whereNotIn('slug', ['declined']);
					});
				}
			])
			->where('user_id', Auth::user()->id)
			->findOrFail($brief_id);

		$sports	= \App\Sport::query()
			->where('is_enabled', 1)
			->orderBy('name', 'asc')
			->get();

		//$tags	= \App\Tag::query()
		//	->orderBy('name', 'asc')
		//	->get();

		$briefstatusmoderation = \App\Briefstatus::query()
			->where('slug', 'moderation')
			->first();

		$briefstatusdraft = \App\Briefstatus::query()
			->where('slug', 'draft')
			->first();

		return view($this->view, compact(
			'brief',
			'sports',
			//'tags',
			'briefstatusmoderation',
			'briefstatusdraft'
		));
	}

	public function update(UpdateRequest $request)
	{
		$brief = \App\Brief::query()
			->select('briefs.*')
			//->with([
			//	'brieftags',
			//])
			->where('user_id', Auth::user()->id)
			->findOrFail($request->brief_id);

		$old = clone $brief;

		$brief->sport_id		= $request->sport_id;
		$brief->briefstatus_id	= $request->briefstatus_id;
		$brief->name			= $request->name;
		$brief->picture_author	= $request->picture_author;
		$brief->announce		= $request->announce;
		$brief->content			= $request->content;
		$brief->posted_at		= now();
		$brief->save();

		//$brief->brieftags()->delete();
		//$brieftag = new \App\Brieftag;
		//$brieftag->brief_id	= $brief->id;
		//$brieftag->tag_id	= $request->tag_id;
		//$brieftag->save();

		return redirect()->route('account.brief.index');
	}

	/**
	 *
	 *
	 */

	public function create()
	{
		$brief	= new \App\Brief;

		$sports	= \App\Sport::query()
			->where('is_enabled', 1)
			->orderBy('name', 'asc')
			->get();

		//$tags	= \App\Tag::query()
		//	->orderBy('name', 'asc')
		//	->get();

		$briefstatusmoderation = \App\Briefstatus::query()
			->where('slug', 'moderation')
			->first();

		$briefstatusdraft = \App\Briefstatus::query()
			->where('slug', 'draft')
			->first();

		return view($this->view, compact(
			'brief',
			'sports',
			//'tags',
			'briefstatusmoderation',
			'briefstatusdraft'
		));
	}

	/**
	 *
	 *
	 */

	public function store(StoreRequest $request)
	{
		$brief = new \App\Brief;
		$brief->user_id			= Auth::user()->id;
		$brief->sport_id		= $request->sport_id;
		$brief->briefstatus_id	= $request->briefstatus_id;
		$brief->name			= $request->name;
		$brief->picture_author	= $request->picture_author;
		$brief->announce		= $request->announce;
		$brief->content			= $request->content;
		$brief->posted_at		= now();
		$brief->save();

		event(new BriefCreated($brief));

		//$brieftag = new \App\Brieftag;
		//$brieftag->brief_id	= $brief->id;
		//$brieftag->tag_id	= $request->tag_id;
		//$brieftag->save();

		return redirect()->route('account.brief.index');
	}

	/**
	 *
	 *
	 */

	public function destroy($brief_id)
	{
		$brief = \App\Brief::query()
			->select('briefs.*')
			->where('user_id', Auth::user()->id)
			->whereHas('briefstatus', function ($query) {
				$query->where('slug', 'draft');
			})
			->findOrFail($brief_id);

		event(new BriefDestroy($brief));

		$brief->delete();
	}
}
