<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Customtype\StoreRequest;
use App\Http\Requests\Office\Customtype\UpdateRequest;

class CustomtypeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.customtype.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Customtype::class);

		$customtypes['rows'] = \App\Customtype::query()
			->withRelations()
			->withCount('customparams')
			->sortBy(
				$customtypes['sort'] 		= $request->sort ?? 'name',
				$customtypes['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('customtypes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$customtype = \App\Customtype::query()
			->withRelations()
			->withCount('customparams')
			->findOrFail($id)
		;

		$this->authorize('read', $customtype);

		$parameters['name'] = $customtype->name;

		// Вложенные параметры
		if (auth()->user()->can('index', \App\Customparam::class))
			$customparams['rows'] = $customtype->customparams()
				->withRelations()
				->sortBy(
					$customparams['sort']		= $request->sort ?? 'name',
					$customparams['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'customtype'
		))
			->with('customparams',	$customparams ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$customtype = new \App\Customtype;

		$this->authorize('create', $customtype);

		return view($this->view, compact('customtype'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Customtype\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$customtype = \App\Customtype::create($request->all());

		$this->authorize('create', $customtype);

		$customtype->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $customtype->id,
			'name'		=> $customtype->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\CustomtypeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$customtype = \App\Customtype::query()
			->findOrFail($id);

		$this->authorize('update', $customtype);

		$customtype->fill($request->all());
		$customtype->save();

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
		$customtype = \App\Customtype::query()
			->findOrFail($id);

		$this->authorize('read', $customtype);

		$parameters['name'] = $customtype->name;

		return view($this->view, compact(
			'parameters',
			'customtype'
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
		$customtype = \App\Customtype::query()
			->findOrFail($id);

		$this->authorize('delete', $customtype);

		$customtype->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Customtype::class);

		$customtypes = \App\Customtype::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($customtypes as $customtype)
			$answer[] = [
				'id'    => $customtype->id,
				'value' => $customtype->name,
			];

		return response()->json($answer, 200);
	}
}
