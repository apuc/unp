<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Brief\StoreRequest;
use App\Http\Requests\Office\Brief\UpdateRequest;

class BriefController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('office.filter.brief', ['only' => ['index']]);

		View::share('sidebar',      'office.brief.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Brief::class);

		$briefs['rows'] = \App\Brief::query()
			->withRelations()
			->withCount('briefcomments')
			->withCount('briefpictures')
			->withCount('brieftags')
			->withCount('brieftournaments')
			->filter()
			->sortBy(
				$briefs['sort'] 			= $request->sort ?? 'posted_at',
				$briefs['direction'] 	= $request->direction ?? 'desc'
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('briefs'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$brief = \App\Brief::query()
			->withRelations()
			->withCount('briefcomments')
			->withCount('briefpictures')
			->withCount('brieftags')
			->findOrFail($id)
		;

		$this->authorize('read', $brief);

		$parameters['name'] = $brief->name;

		// Вложенные комментарии
		if (auth()->user()->can('index', \App\Briefcomment::class))
			$briefcomments['rows'] = $brief->briefcomments()
				->withRelations()
				->sortBy(
					$briefcomments['sort']		= $request->sort ?? 'name',
					$briefcomments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные изображения
		if (auth()->user()->can('index', \App\Briefpicture::class))
			$briefpictures['rows'] = $brief->briefpictures()
				->withRelations()
				->sortBy(
					$briefpictures['sort']		= $request->sort ?? 'name',
					$briefpictures['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные теги
		if (auth()->user()->can('index', \App\Brieftag::class))
			$brieftags['rows'] = $brief->brieftags()
				->withRelations()
				->sortBy(
					$brieftags['sort'] 		= $request->sort ?? 'name',
					$brieftags['direction'] 	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные турниры
		if (auth()->user()->can('index', \App\Brieftournament::class))
			$brieftournaments['rows'] = $brief->brieftournaments()
				->withRelations()
				->sortBy(
					$brieftournaments['sort'] 		= $request->sort ?? 'name',
					$brieftournaments['direction'] 	= $request->direction
				)
				->paginate(config('interface.paginator'));


		return view($this->view, compact(
			'parameters',
			'brief'
		))
			->with('briefcomments',		$briefcomments ?? [])
			->with('briefpictures',		$briefpictures ?? [])
			->with('brieftags',			$brieftags ?? [])
			->with('brieftournaments',	$brieftournaments ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$brief = new \App\Brief;

		$this->authorize('create', $brief);

		$brief->posted_at = now();

		return view($this->view, compact('brief'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Brief\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$brief = \App\Brief::create($request->all());;

		$this->authorize('create', $brief);

		$brief->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $brief->id,
			'name'		=> $brief->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BriefUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$brief = \App\Brief::query()
			->findOrFail($id)
		;

		$old = clone $brief;

		$this->authorize('update', $brief);

		$brief->fill($request->all());
		$brief->save();

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
		$brief = \App\Brief::query()
			->findOrFail($id);

		$this->authorize('read', $brief);

		$parameters['name'] = $brief->name;

		return view($this->view, compact(
			'parameters',
			'brief'
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
		$brief = \App\Brief::query()
			->findOrFail($id);

		$this->authorize('delete', $brief);

		$brief->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Brief::class);

		$briefs = \App\Brief::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($briefs as $brief)
			$answer[] = [
				'id'    => $brief->id,
				'value' => $brief->name,
			];

		return response()->json($answer, 200);
	}
}
