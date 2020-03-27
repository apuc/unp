<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Outcomescope\StoreRequest;
use App\Http\Requests\Office\Outcomescope\UpdateRequest;

class OutcomescopeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.outcomescope.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Outcomescope::class);

		$outcomescopes['rows'] = \App\Outcomescope::query()
			->withRelations()
			->sortBy(
				$outcomescopes['sort']			= $request->sort ?? 'name',
				$outcomescopes['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('outcomescopes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$outcomescope = \App\Outcomescope::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $outcomescope);

		$parameters['name'] = $outcomescope->name;

		return view($this->view, compact(
			'parameters',
			'outcomescope'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$outcomescope = new \App\Outcomescope;

		$this->authorize('create', $outcomescope);

		return view($this->view, compact('outcomescope'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Outcomescope\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$outcomescope = \App\Outcomescope::create($request->all());

		$this->authorize('create', $outcomescope);

		$outcomescope->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $outcomescope->id,
			'name'		=> $outcomescope->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\OutcomescopeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$outcomescope = \App\Outcomescope::query()
			->findOrFail($id);

		$this->authorize('update', $outcomescope);

		$outcomescope->fill($request->all());
		$outcomescope->save();

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
		$outcomescope = \App\Outcomescope::query()
			->findOrFail($id);

		$this->authorize('read', $outcomescope);

		$parameters['name'] = $outcomescope->name;

		return view($this->view, compact(
			'parameters',
			'outcomescope'
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
		$outcomescope = \App\Outcomescope::query()
			->findOrFail($id);

		$this->authorize('delete', $outcomescope);

		$outcomescope->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Outcomescope::class);

		$outcomescopes = \App\Outcomescope::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($outcomescopes as $outcomescope)
			$answer[] = [
				'id'    => $outcomescope->id,
				'value' => $outcomescope->name,
			];

		return response()->json($answer, 200);
	}
}
