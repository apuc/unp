<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Tournament\StoreRequest;
use App\Http\Requests\Office\Tournament\UpdateRequest;

class TournamentController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('office.filter.tournament', ['only' => ['index']]);

		View::share('sidebar', 'office.tournament.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Tournament::class);

		$tournaments['rows'] = \App\Tournament::query()
			->withRelations()
			->withCount('seasons')
			->withCount('posttournaments as tournamentposts_count')
			->withCount('brieftournaments as tournamentbriefs_count')
			->filter()
			->sortBy(
				$tournaments['sort'] 		= $request->sort ?? 'name',
				$tournaments['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'))
		;

		return view($this->view, compact('tournaments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$tournament = \App\Tournament::query()
			->withRelations()
			->withCount('seasons')
			->withCount('posttournaments as tournamentposts_count')
			->withCount('brieftournaments as tournamentbriefs_count')
			->findOrFail($id)
		;

		$this->authorize('read', $tournament);

		$parameters['name'] = $tournament->name;

		// Вложенные сезоны
		if (auth()->user()->can('index', \App\Season::class))
			$seasons['rows'] = $tournament->seasons()
				->withRelations()
				->withCount('stages')
				->sortBy(
					$seasons['sort']		= $request->sort ?? 'name',
					$seasons['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'))
			;

		// Вложенные посты
		if (auth()->user()->can('index', \App\Posttournament::class))
			$posttournaments['rows'] = $tournament->posttournaments()
				->withRelations()
				->sortBy(
					$posttournaments['sort']		= $request->sort ?? 'name',
					$posttournaments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'))
			;

		// Вложенные новости
		if (auth()->user()->can('index', \App\Brieftournament::class))
			$brieftournaments['rows'] = $tournament->brieftournaments()
				->withRelations()
				->sortBy(
					$brieftournaments['sort']		= $request->sort ?? 'name',
					$brieftournaments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'))
			;

		return view($this->view, compact(
			'parameters',
			'tournament'
		))
			->with('seasons',			$seasons 			?? [])
			->with('posttournaments',	$posttournaments	?? [])
			->with('brieftournaments',	$brieftournaments	?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$tournament = new \App\Tournament;

		$this->authorize('create', $tournament);

		return view($this->view, compact('tournament'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Tournament\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$tournament = \App\Tournament::create($request->all());;

		$this->authorize('create', $tournament);

		$tournament->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $tournament->id,
			'name'		=> $tournament->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\TournamentUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$tournament = \App\Tournament::query()
			->findOrFail($id);

		$this->authorize('update', $tournament);

		$tournament->fill($request->all());
		$tournament->save();

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
		$tournament = \App\Tournament::query()
			->findOrFail($id);

		$this->authorize('read', $tournament);

		$parameters['name'] = $tournament->name;

		return view($this->view, compact(
			'parameters',
			'tournament'
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
		$tournament = \App\Tournament::query()
			->findOrFail($id);

		$this->authorize('delete', $tournament);

		$tournament->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Tournament::class);

		$query = \App\Tournament::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
		;

		if ($request->has('brief_id'))
			$query->where('tournaments.sport_id', \App\Brief::find($request->brief_id)->sport_id);

		if ($request->has('post_id'))
			$query->where('tournaments.sport_id', \App\Post::find($request->post_id)->sport_id);

		$tournaments = $query->paginate(config('interface.select'));

		$answer = [];
		foreach ($tournaments as $tournament)
			$answer[] = [
				'id'    => $tournament->id,
				'value' => $tournament->name,
			];

		return response()->json($answer, 200);
	}
}
