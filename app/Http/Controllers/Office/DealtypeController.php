<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Dealtype\StoreRequest;
use App\Http\Requests\Office\Dealtype\UpdateRequest;

class DealtypeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.dealtype.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Dealtype::class);

		$dealtypes['rows'] = \App\Dealtype::query()
			->withRelations()
			->withCount('deals')
			->sortBy(
				$dealtypes['sort'] 		= $request->sort ?? 'name',
				$dealtypes['direction'] = $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('dealtypes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$dealtype = \App\Dealtype::query()
			->withRelations()
			->withCount('deals')
			->findOrFail($id)
		;

		$this->authorize('read', $dealtype);

		$parameters['name'] = $dealtype->name;

		// Вложенные акции
		if (auth()->user()->can('index', \App\Deal::class))
			$deals['rows'] = $dealtype->deals()
				->withRelations()
				->sortBy(
					$deals['sort'] 		= $request->sort ?? 'name',
					$deals['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'dealtype'
		))
			->with('deals',	$deals ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$dealtype = new \App\Dealtype;

		$this->authorize('create', $dealtype);

		return view($this->view, compact('dealtype'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Dealtype\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$dealtype = \App\Dealtype::create($request->all());;

		$this->authorize('create', $dealtype);

		$dealtype->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $dealtype->id,
			'name'		=> $dealtype->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\DealtypeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$dealtype = \App\Dealtype::query()
			->findOrFail($id);

		$this->authorize('update', $dealtype);

		$dealtype->fill($request->all());
		$dealtype->save();

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
		$dealtype = \App\Dealtype::query()
			->findOrFail($id);

		$this->authorize('read', $dealtype);

		$parameters['name'] = $dealtype->name;

		return view($this->view, compact(
			'parameters',
			'dealtype'
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
		$dealtype = \App\Dealtype::query()
			->findOrFail($id);

		$this->authorize('delete', $dealtype);

		$dealtype->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Dealtype::class);

		$dealtypes = \App\Dealtype::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($dealtypes as $dealtype)
			$answer[] = [
				'id'    => $dealtype->id,
				'value' => $dealtype->name,
			];

		return response()->json($answer, 200);
	}
}
