<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Tag\StoreRequest;
use App\Http\Requests\Office\Tag\UpdateRequest;

class TagController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.tag.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Tag::class);

		$tags['rows'] = \App\Tag::query()
			->withRelations()
			->withCount('posttags')
			->withCount('brieftags')
			->sortBy(
				$tags['sort'] 		= $request->sort ?? 'name',
				$tags['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('tags'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$tag = \App\Tag::query()
			->withRelations()
			->withCount('posttags')
			->withCount('brieftags')
			->findOrFail($id)
		;

		$this->authorize('read', $tag);

		$parameters['name'] = $tag->name;

		// Вложенные теги публикаций
		if (auth()->user()->can('index', \App\Posttag::class))
			$posttags['rows'] = $tag->posttags()
				->withRelations()
				->sortBy(
					$posttags['sort']		= $request->sort ?? 'name',
					$posttags['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные теги новостей
		if (auth()->user()->can('index', \App\Brieftag::class))
			$brieftags['rows'] = $tag->brieftags()
				->withRelations()
				->sortBy(
					$brieftags['sort']		= $request->sort ?? 'name',
					$brieftags['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'tag'
		))
			->with('posttags',	$posttags ?? [])
			->with('brieftags',	$brieftags ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$tag = new \App\Tag;

		$this->authorize('create', $tag);

		return view($this->view, compact('tag'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Tag\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$tag = \App\Tag::create($request->all());

		$this->authorize('create', $tag);

		$tag->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $tag->id,
			'name'		=> $tag->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\TagUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$tag = \App\Tag::query()
			->findOrFail($id);

		$this->authorize('update', $tag);

		$tag->fill($request->all());
		$tag->save();

		return response()->json(['status' => 'success'], 200);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function edit($id)
	{
		$tag = \App\Tag::query()
			->findOrFail($id);

		$this->authorize('read', $tag);

		$parameters['name'] = $tag->name;

		return view($this->view, compact(
			'parameters',
			'tag'
		));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$tag = \App\Tag::query()
			->findOrFail($id);

		$this->authorize('delete', $tag);

		$tag->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Tag::class);

		$tags = \App\Tag::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($tags as $tag)
			$answer[] = [
				'id'    => $tag->id,
				'value' => $tag->name,
			];

		return response()->json($answer, 200);
	}
}
