<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Brieftournament\StoreRequest;
use App\Http\Requests\Office\Brieftournament\UpdateRequest;

class BrieftournamentController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.brieftournament.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Brieftournament::class);

		$brieftournaments['rows'] = \App\Brieftournament::query()
			->withRelations()
//			->withCount('users')
			->sortBy(
				$brieftournaments['sort'] 		= $request->sort ?? 'name',
				$brieftournaments['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('brieftournaments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$brieftournament = \App\Brieftournament::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $brieftournament);

		$parameters['name'] = $brieftournament->name;

		return view($this->view, compact(
			'parameters',
			'brieftournament'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$brieftournament = new \App\Brieftournament;

		$this->authorize('create', $brieftournament);

		return view($this->view, compact('brieftournament'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Brieftournament\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$brieftournament = \App\Brieftournament::create($request->all());;

		$this->authorize('create', $brieftournament);

		$brieftournament->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $brieftournament->id,
			'name'		=> $brieftournament->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BrieftournamentUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$brieftournament = \App\Brieftournament::query()
			->findOrFail($id);

		$this->authorize('update', $brieftournament);

		$brieftournament->fill($request->all());
		$brieftournament->save();

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
		$brieftournament = \App\Brieftournament::query()
			->findOrFail($id);

		$this->authorize('read', $brieftournament);

		$parameters['name'] = $brieftournament->name;

		return view($this->view, compact(
			'parameters',
			'brieftournament'
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
		$brieftournament = \App\Brieftournament::query()
			->findOrFail($id);

		$this->authorize('delete', $brieftournament);

		$brieftournament->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Brieftournament::class);

		$brieftournaments = \App\Brieftournament::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($brieftournaments as $brieftournament)
			$answer[] = [
				'id'    => $brieftournament->id,
				'value' => $brieftournament->name,
			];

		return response()->json($answer, 200);
	}
}
