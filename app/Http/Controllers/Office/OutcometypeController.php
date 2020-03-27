<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Outcometype\StoreRequest;
use App\Http\Requests\Office\Outcometype\UpdateRequest;

class OutcometypeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.outcometype.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Outcometype::class);

		$outcometypes['rows'] = \App\Outcometype::query()
			->withRelations()
			->withCount('outcomes')
			->sortBy(
				$outcometypes['sort'] 		= $request->sort ?? 'name',
				$outcometypes['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('outcometypes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$outcometype = \App\Outcometype::query()
			->withRelations()
			->withCount('outcomes')
			->findOrFail($id)
		;

		$this->authorize('read', $outcometype);

		$parameters['name'] = $outcometype->name;

		// Вложенные исходы
		if (auth()->user()->can('index', \App\Outcome::class))
			$outcomes['rows'] = $outcometype->outcomes()
				->withRelations()
				->sortBy(
					$outcomes['sort']		= $request->sort ?? 'name',
					$outcomes['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'outcometype'
		))
			->with('outcomes',	$outcomes ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$outcometype = new \App\Outcometype;

		$this->authorize('create', $outcometype);

		return view($this->view, compact('outcometype'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Outcometype\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$outcometype = \App\Outcometype::create($request->all());

		$this->authorize('create', $outcometype);

		$outcometype->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $outcometype->id,
			'name'		=> $outcometype->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\OutcometypeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$outcometype = \App\Outcometype::query()
			->findOrFail($id);

		$this->authorize('update', $outcometype);

		$outcometype->fill($request->all());
		$outcometype->save();

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
		$outcometype = \App\Outcometype::query()
			->findOrFail($id);

		$this->authorize('read', $outcometype);

		$parameters['name'] = $outcometype->name;

		return view($this->view, compact(
			'parameters',
			'outcometype'
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
		$outcometype = \App\Outcometype::query()
			->findOrFail($id);

		$this->authorize('delete', $outcometype);

		$outcometype->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Outcometype::class);

		$outcometypes = \App\Outcometype::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($outcometypes as $outcometype)
			$answer[] = [
				'id'    => $outcometype->id,
				'value' => $outcometype->name,
			];

		return response()->json($answer, 200);
	}
}
