<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Tournamenttype\StoreRequest;
use App\Http\Requests\Office\Tournamenttype\UpdateRequest;

class TournamenttypeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.tournamenttype.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Tournamenttype::class);

		$tournamenttypes['rows'] = \App\Tournamenttype::query()
			->withRelations()
			->withCount('tournaments')
			->sortBy(
				$tournamenttypes['sort'] 		= $request->sort ?? 'name',
				$tournamenttypes['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('tournamenttypes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$tournamenttype = \App\Tournamenttype::query()
			->withRelations()
			->withCount('tournaments')
			->findOrFail($id)
		;

		$this->authorize('read', $tournamenttype);

		$parameters['name'] = $tournamenttype->name;

		// Вложенные турниры
		if (auth()->user()->can('index', \App\Tournament::class))
			$tournaments['rows'] = $tournamenttype->tournaments()
				->withRelations()
				->withCount('seasons')
				->withCount('posttournaments as tournamentposts_count')
				->withCount('brieftournaments as tournamentbriefs_count')
				->sortBy(
					$tournaments['sort']		= $request->sort ?? 'name',
					$tournaments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'tournaments',
			'tournamenttype'
		))
			->with('stages',	$stages ?? [])
			->with('seasons',	$seasons ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$tournamenttype = new \App\Tournamenttype;

		$this->authorize('create', $tournamenttype);

		return view($this->view, compact('tournamenttype'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Tournamenttype\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$tournamenttype = \App\Tournamenttype::create($request->all());

		$this->authorize('create', $tournamenttype);

		$tournamenttype->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $tournamenttype->id,
			'name'		=> $tournamenttype->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\TournamenttypeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$tournamenttype = \App\Tournamenttype::query()
			->findOrFail($id);

		$this->authorize('update', $tournamenttype);

		$tournamenttype->fill($request->all());
		$tournamenttype->save();

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
		$tournamenttype = \App\Tournamenttype::query()
			->findOrFail($id);

		$this->authorize('read', $tournamenttype);

		$parameters['name'] = $tournamenttype->name;

		return view($this->view, compact(
			'parameters',
			'tournamenttype'
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
		$tournamenttype = \App\Tournamenttype::query()
			->findOrFail($id);

		$this->authorize('delete', $tournamenttype);

		$tournamenttype->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Tournamenttype::class);

		$tournamenttypes = \App\Tournamenttype::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($tournamenttypes as $tournamenttype)
			$answer[] = [
				'id'    => $tournamenttype->id,
				'value' => $tournamenttype->name,
			];

		return response()->json($answer, 200);
	}
}
