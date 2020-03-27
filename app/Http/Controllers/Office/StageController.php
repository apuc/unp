<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Stage\StoreRequest;
use App\Http\Requests\Office\Stage\UpdateRequest;

class StageController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.stage.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Stage::class);

		$stages['rows'] = \App\Stage::query()
			->withRelations()
			->withCount('matches')
			->sortBy(
				$stages['sort'] 		= $request->sort ?? 'name',
				$stages['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('stages'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$stage = \App\Stage::query()
			->withRelations()
			->withCount('matches')
			->findOrFail($id)
		;

		$this->authorize('read', $stage);

		$parameters['name'] = $stage->name;

		// Вложенные матчи
		if (auth()->user()->can('index', \App\Match::class))
			$matches['rows'] = $stage->matches()
				->withRelations()
				->withCount('participants')
				->withCount('forecasts')
				->sortBy(
					$matches['sort']		= $request->sort ?? 'name',
					$matches['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'stage'
		))
			->with('matches',	$matches ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$stage = new \App\Stage;

		$this->authorize('create', $stage);

		return view($this->view, compact('stage'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Stage\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$stage = \App\Stage::create($request->all());;

		$this->authorize('create', $stage);

		$stage->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $stage->id,
			'name'		=> $stage->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\StageUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$stage = \App\Stage::query()
			->findOrFail($id);

		$this->authorize('update', $stage);

		$stage->fill($request->all());
		$stage->save();

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
		$stage = \App\Stage::query()
			->findOrFail($id);

		$this->authorize('read', $stage);

		$parameters['name'] = $stage->name;

		return view($this->view, compact(
			'parameters',
			'stage'
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
		$stage = \App\Stage::query()
			->findOrFail($id);

		$this->authorize('delete', $stage);

		$stage->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Stage::class);

		$stages = \App\Stage::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($stages as $stage)
			$answer[] = [
				'id'    => $stage->id,
				'value' => $stage->name,
			];

		return response()->json($answer, 200);
	}
}
