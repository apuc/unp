<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Customparam\StoreRequest;
use App\Http\Requests\Office\Customparam\UpdateRequest;

class CustomparamController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.customparam.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Customparam::class);

		$customparams['rows'] = \App\Customparam::query()
			->withRelations()
			->sortBy(
				$customparams['sort'] 		= $request->sort ?? 'name',
				$customparams['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('customparams'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$customparam = \App\Customparam::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $customparam);

		$parameters['name'] = $customparam->name;

		return view($this->view, compact(
			'parameters',
			'customparam'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$customparam = new \App\Customparam;

		$this->authorize('create', $customparam);

		return view($this->view, compact('customparam'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Customparam\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$customparam = \App\Customparam::create($request->all());;

		$this->authorize('create', $customparam);

		$customparam->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $customparam->id,
			'name'		=> $customparam->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\CustomparamUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$customparam = \App\Customparam::query()
			->findOrFail($id);

		$this->authorize('update', $customparam);

		$customparam->fill($request->all());
		$customparam->save();

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
		$customparam = \App\Customparam::query()
			->findOrFail($id);

		$this->authorize('read', $customparam);

		$parameters['name'] = $customparam->name;

		return view($this->view, compact(
			'parameters',
			'customparam'
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
		$customparam = \App\Customparam::query()
			->findOrFail($id);

		$this->authorize('delete', $customparam);

		$customparam->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Customparam::class);

		$customparams = \App\Customparam::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($customparams as $customparam)
			$answer[] = [
				'id'    => $customparam->id,
				'value' => $customparam->name,
			];

		return response()->json($answer, 200);
	}
}
