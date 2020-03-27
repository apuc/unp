<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Posttournament\StoreRequest;
use App\Http\Requests\Office\Posttournament\UpdateRequest;

class PosttournamentController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.posttournament.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Posttournament::class);

		$posttournaments['rows'] = \App\Posttournament::query()
			->withRelations()
//			->withCount('users')
			->sortBy(
				$posttournaments['sort'] 		= $request->sort ?? 'name',
				$posttournaments['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('posttournaments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$posttournament = \App\Posttournament::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $posttournament);

		$parameters['name'] = $posttournament->name;

		return view($this->view, compact(
			'parameters',
			'posttournament'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$posttournament = new \App\Posttournament;

		$this->authorize('create', $posttournament);

		return view($this->view, compact('posttournament'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Posttournament\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$posttournament = \App\Posttournament::create($request->all());;

		$this->authorize('create', $posttournament);

		$posttournament->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $posttournament->id,
			'name'		=> $posttournament->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\PosttournamentUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$posttournament = \App\Posttournament::query()
			->findOrFail($id);

		$this->authorize('update', $posttournament);

		$posttournament->fill($request->all());
		$posttournament->save();

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
		$posttournament = \App\Posttournament::query()
			->findOrFail($id);

		$this->authorize('read', $posttournament);

		$parameters['name'] = $posttournament->name;

		return view($this->view, compact(
			'parameters',
			'posttournament'
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
		$posttournament = \App\Posttournament::query()
			->findOrFail($id);

		$this->authorize('delete', $posttournament);

		$posttournament->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Posttournament::class);

		$posttournaments = \App\Posttournament::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($posttournaments as $posttournament)
			$answer[] = [
				'id'    => $posttournament->id,
				'value' => $posttournament->name,
			];

		return response()->json($answer, 200);
	}
}
