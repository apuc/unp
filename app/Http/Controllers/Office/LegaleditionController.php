<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Legaledition\StoreRequest;
use App\Http\Requests\Office\Legaledition\UpdateRequest;

class LegaleditionController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.legaledition.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Legaledition::class);

		$legaleditions['rows'] = \App\Legaledition::query()
			->withRelations()
			->sortBy(
				$legaleditions['sort'] 		= $request->sort ?? 'issued_at',
				$legaleditions['direction'] = $request->direction ?? 'desc'
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('legaleditions'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$legaledition = \App\Legaledition::query()
			->withRelations()
			->findOrFail($id);

		$this->authorize('read', $legaledition);

		$parameters['name'] = $legaledition->name;

		return view($this->view, compact(
			'parameters',
			'legaledition'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$legaledition = new \App\Legaledition;

		$this->authorize('create', $legaledition);

		return view($this->view, compact('legaledition'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Legaledition\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$legaledition = \App\Legaledition::create($request->all());;

		$this->authorize('create', $legaledition);

		$legaledition->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $legaledition->id,
			'name'		=> $legaledition->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\LegaleditionUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$legaledition = \App\Legaledition::query()
			->findOrFail($id);

		$this->authorize('update', $legaledition);

		$legaledition->fill($request->all());
		$legaledition->save();

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
		$legaledition = \App\Legaledition::query()
			->findOrFail($id);

		$this->authorize('read', $legaledition);

		$parameters['name'] = $legaledition->name;

		return view($this->view, compact(
			'parameters',
			'legaledition'
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
		$legaledition = \App\Legaledition::query()
			->findOrFail($id);

		$this->authorize('delete', $legaledition);

		$legaledition->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Legaledition::class);

		$legaleditions = \App\Legaledition::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($legaleditions as $legaledition)
			$answer[] = [
				'id'    => $legaledition->id,
				'value' => $legaledition->name,
			];

		return response()->json($answer, 200);
	}
}
