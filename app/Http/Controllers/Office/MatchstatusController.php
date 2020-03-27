<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Matchstatus\StoreRequest;
use App\Http\Requests\Office\Matchstatus\UpdateRequest;

class MatchstatusController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.matchstatus.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Matchstatus::class);

		$matchstatuses['rows'] = \App\Matchstatus::query()
			->withRelations()
			->withCount('matches')
			->sortBy(
				$matchstatuses['sort']		= $request->sort ?? 'name',
				$matchstatuses['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'))
		;

		return view($this->view, compact('matchstatuses'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$matchstatus = \App\Matchstatus::query()
			->withRelations()
			->withCount('matches')
			->findOrFail($id)
		;

		$this->authorize('read', $matchstatus);

		$parameters['name'] = $matchstatus->name;

		// Вложенные матчи
		if (auth()->user()->can('index', \App\Match::class))
			$matches['rows'] = $matchstatus->matches()
				->withRelations()
				->withCount('participants')
				->withCount('forecasts')
				->sortBy(
					$matches['sort']      = $request->sort ?? 'created_at',
					$matches['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'))
			;

		return view($this->view, compact(
			'parameters',
			'matchstatus'
		))
			->with('matches', $matches ?? [])
		;

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$matchstatus = new \App\Matchstatus;

		$this->authorize('create', $matchstatus);

		return view($this->view, compact('matchstatus'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\MatchstatusStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$matchstatus = \App\Matchstatus::create($request->all());

		$this->authorize('create', $matchstatus);

		$matchstatus->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $matchstatus->id,
			'name'		=> $matchstatus->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\MatchstatusUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(UpdateRequest $request, $id)
	{
		$matchstatus = \App\Matchstatus::query()
			->findOrFail($id);

		$this->authorize('update', $matchstatus);

		$matchstatus->fill($request->all());
		$matchstatus->save();

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
		$matchstatus = \App\Matchstatus::query()
			->findOrFail($id);

		$this->authorize('read', $matchstatus);

		$parameters['name'] = $matchstatus->name;

		return view($this->view, compact(
			'parameters',
			'matchstatus'
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
		$matchstatus = \App\Matchstatus::query()
			->findOrFail($id);

		$this->authorize('delete', $matchstatus);

		$matchstatus->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Matchstatus::class);

		$matchstatuses = \App\Matchstatus::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($matchstatuses as $matchstatus)
			$answer[] = [
				'id'	=> $matchstatus->id,
				'value'	=> $matchstatus->name
			];

		return response()->json($answer, 200);
	}
}
