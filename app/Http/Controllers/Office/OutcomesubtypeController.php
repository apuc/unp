<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Outcomesubtype\StoreRequest;
use App\Http\Requests\Office\Outcomesubtype\UpdateRequest;

class OutcomesubtypeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.outcomesubtype.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Outcomesubtype::class);

		$outcomesubtypes['rows'] = \App\Outcomesubtype::query()
			->withRelations()
			->sortBy(
				$outcomesubtypes['sort'] 		= $request->sort ?? 'name',
				$outcomesubtypes['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('outcomesubtypes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$outcomesubtype = \App\Outcomesubtype::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $outcomesubtype);

		$parameters['name'] = $outcomesubtype->name;

		return view($this->view, compact(
			'parameters',
			'outcomesubtype'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$outcomesubtype = new \App\Outcomesubtype;

		$this->authorize('create', $outcomesubtype);

		return view($this->view, compact('outcomesubtype'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Outcomesubtype\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$outcomesubtype = \App\Outcomesubtype::create($request->all());

		$this->authorize('create', $outcomesubtype);

		$outcomesubtype->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $outcomesubtype->id,
			'name'		=> $outcomesubtype->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\OutcomesubtypeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$outcomesubtype = \App\Outcomesubtype::query()
			->findOrFail($id);

		$this->authorize('update', $outcomesubtype);

		$outcomesubtype->fill($request->all());
		$outcomesubtype->save();

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
		$outcomesubtype = \App\Outcomesubtype::query()
			->findOrFail($id);

		$this->authorize('read', $outcomesubtype);

		$parameters['name'] = $outcomesubtype->name;

		return view($this->view, compact(
			'parameters',
			'outcomesubtype'
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
		$outcomesubtype = \App\Outcomesubtype::query()
			->findOrFail($id);

		$this->authorize('delete', $outcomesubtype);

		$outcomesubtype->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Outcomesubtype::class);

		$outcomesubtypes = \App\Outcomesubtype::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($outcomesubtypes as $outcomesubtype)
			$answer[] = [
				'id'    => $outcomesubtype->id,
				'value' => $outcomesubtype->name,
			];

		return response()->json($answer, 200);
	}
}
