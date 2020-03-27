<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Season\StoreRequest;
use App\Http\Requests\Office\Season\UpdateRequest;

class SeasonController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.season.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Season::class);

		$seasons['rows'] = \App\Season::query()
			->withRelations()
			->withCount('stages')
			->sortBy(
				$seasons['sort'] 		= $request->sort ?? 'name',
				$seasons['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('seasons'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$season = \App\Season::query()
			->withRelations()
			->withCount('stages')
			->findOrFail($id)
		;

		$this->authorize('read', $season);

		$parameters['name'] = $season->name;

		// Вложенные этапы
		if (auth()->user()->can('index', \App\Stage::class))
			$stages['rows'] = $season->stages()
				->withRelations()
				->withCount('matches')
				->sortBy(
					$stages['sort']			= $request->sort ?? 'name',
					$stages['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'season'
		))
			->with('stages', $stages ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$season = new \App\Season;

		$this->authorize('create', $season);

		return view($this->view, compact('season'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Season\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$season = \App\Season::create($request->all());;

		$this->authorize('create', $season);

		$season->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $season->id,
			'name'		=> $season->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\SeasonUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$season = \App\Season::query()
			->findOrFail($id);

		$this->authorize('update', $season);

		$season->fill($request->all());
		$season->save();

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
		$season = \App\Season::query()
			->findOrFail($id);

		$this->authorize('read', $season);

		$parameters['name'] = $season->name;

		return view($this->view, compact(
			'parameters',
			'season'
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
		$season = \App\Season::query()
			->findOrFail($id);

		$this->authorize('delete', $season);

		$season->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Season::class);

		$seasons = \App\Season::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($seasons as $season)
			$answer[] = [
				'id'    => $season->id,
				'value' => $season->name,
			];

		return response()->json($answer, 200);
	}
}
