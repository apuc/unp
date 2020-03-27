<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Benefit\StoreRequest;
use App\Http\Requests\Office\Benefit\UpdateRequest;

class BenefitController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.benefit.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Benefit::class);

		$benefits['rows'] = \App\Benefit::query()
			->withRelations()
			->sortBy(
				$benefits['sort'] 		= $request->sort ?? 'name',
				$benefits['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('benefits'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$benefit = \App\Benefit::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $benefit);

		$parameters['name'] = $benefit->name;

		return view($this->view, compact(
			'parameters',
			'benefit'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$benefit = new \App\Benefit;

		$this->authorize('create', $benefit);

		return view($this->view, compact('benefit'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Benefit\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$benefit = \App\Benefit::create($request->all());

		$this->authorize('create', $benefit);

		$benefit->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $benefit->id,
			'name'		=> $benefit->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BenefitUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$benefit = \App\Benefit::query()
			->findOrFail($id);

		$this->authorize('update', $benefit);

		$benefit->fill($request->all());
		$benefit->save();

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
		$benefit = \App\Benefit::query()
			->findOrFail($id);

		$this->authorize('read', $benefit);

		$parameters['name'] = $benefit->name;

		return view($this->view, compact(
			'parameters',
			'benefit'
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
		$benefit = \App\Benefit::query()
			->findOrFail($id);

		$this->authorize('delete', $benefit);

		$benefit->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Benefit::class);

		$benefits = \App\Benefit::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($benefits as $benefit)
			$answer[] = [
				'id'    => $benefit->id,
				'value' => $benefit->name,
			];

		return response()->json($answer, 200);
	}
}
