<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Counter\StoreRequest;
use App\Http\Requests\Office\Counter\UpdateRequest;

class CounterController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.counter.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Counter::class);

		$counters['rows'] = \App\Counter::query()
			->withRelations()
			->sortBy(
				$counters['sort'] 		= $request->sort ?? 'name',
				$counters['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('counters'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$counter = \App\Counter::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $counter);

		$parameters['name'] = $counter->name;

		return view($this->view, compact(
			'parameters',
			'counter'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$counter = new \App\Counter;

		$this->authorize('create', $counter);

		return view($this->view, compact('counter'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Counter\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$counter = \App\Counter::create($request->all());

		$this->authorize('create', $counter);

		$counter->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $counter->id,
			'name'		=> $counter->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\CounterUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$counter = \App\Counter::query()
			->findOrFail($id);

		$this->authorize('update', $counter);

		$counter->fill($request->all());
		$counter->save();

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
		$counter = \App\Counter::query()
			->findOrFail($id);

		$this->authorize('read', $counter);

		$parameters['name'] = $counter->name;

		return view($this->view, compact(
			'parameters',
			'counter'
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
		$counter = \App\Counter::query()
			->findOrFail($id);

		$this->authorize('delete', $counter);

		$counter->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Counter::class);

		$counters = \App\Counter::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($counters as $counter)
			$answer[] = [
				'id'    => $counter->id,
				'value' => $counter->name,
			];

		return response()->json($answer, 200);
	}
}
