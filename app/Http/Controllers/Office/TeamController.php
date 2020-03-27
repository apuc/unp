<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Team\StoreRequest;
use App\Http\Requests\Office\Team\UpdateRequest;

class TeamController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('office.filter.team', ['only' => ['index']]);

		View::share('sidebar', 'office.team.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Team::class);

		$teams['rows'] = \App\Team::query()
			->withRelations()
			->withCount('participants')
			->filter()
			->sortBy(
				$teams['sort'] 		= $request->sort ?? 'name',
				$teams['direction'] = $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('teams'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$team = \App\Team::query()
			->withRelations()
			->withCount('participants')
			->findOrFail($id)
		;

		$this->authorize('read', $team);

		$parameters['name'] = $team->name;

		// Вложенные участники
		if (auth()->user()->can('index', \App\Participant::class))
			$participants['rows'] = $team->participants()
				->withRelations()
				->sortBy(
					$participants['sort']		= $request->sort ?? 'name',
					$participants['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'team'
		))
			->with('participants',	$participants ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$team = new \App\Team;

		$this->authorize('create', $team);

		return view($this->view, compact('team'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Team\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$team = \App\Team::create($request->all());;

		$this->authorize('create', $team);

		$team->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $team->id,
			'name'		=> $team->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\TeamUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$team = \App\Team::query()
			->findOrFail($id);

		$this->authorize('update', $team);

		$team->fill($request->all());
		$team->save();

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
		$team = \App\Team::query()
			->findOrFail($id);

		$this->authorize('read', $team);

		$parameters['name'] = $team->name;

		return view($this->view, compact(
			'parameters',
			'team'
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
		$team = \App\Team::query()
			->findOrFail($id);

		$this->authorize('delete', $team);

		$team->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Team::class);

		$teams = \App\Team::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($teams as $team)
			$answer[] = [
				'id'    => $team->id,
				'value' => $team->name,
			];

		return response()->json($answer, 200);
	}
}
