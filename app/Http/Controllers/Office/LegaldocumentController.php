<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Legaldocument\StoreRequest;
use App\Http\Requests\Office\Legaldocument\UpdateRequest;

class LegaldocumentController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.legaldocument.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Legaldocument::class);

		$legaldocuments['rows'] = \App\Legaldocument::query()
			->withRelations()
			->withCount('legaleditions')
			->sortBy(
				$legaldocuments['sort'] 		= $request->sort ?? 'name',
				$legaldocuments['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('legaldocuments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$legaldocument = \App\Legaldocument::query()
			->withRelations()
			->withCount('legaleditions')
			->findOrFail($id)
		;

		$this->authorize('read', $legaldocument);

		$parameters['name'] = $legaldocument->name;

		// Вложенные редакции документов
		if (auth()->user()->can('index', \App\Legaledition::class))
			$legaleditions['rows'] = $legaldocument->legaleditions()
				->withRelations()
				->sortBy(
					$legaleditions['sort'] 		= $request->sort ?? 'issued_at',
					$legaleditions['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'legaldocument'
		))
			->with('legaleditions',	$legaleditions ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$legaldocument = new \App\Legaldocument;

		$this->authorize('create', $legaldocument);

		return view($this->view, compact('legaldocument'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Legaldocument\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$legaldocument = \App\Legaldocument::create($request->all());

		$this->authorize('create', $legaldocument);

		$legaldocument->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $legaldocument->id,
			'name'		=> $legaldocument->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\LegaldocumentUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$legaldocument = \App\Legaldocument::query()
			->findOrFail($id);

		$this->authorize('update', $legaldocument);

		$legaldocument->fill($request->all());
		$legaldocument->save();

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
		$legaldocument = \App\Legaldocument::query()
			->findOrFail($id);

		$this->authorize('read', $legaldocument);

		$parameters['name'] = $legaldocument->name;

		return view($this->view, compact(
			'parameters',
			'legaldocument'
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
		$legaldocument = \App\Legaldocument::query()
			->findOrFail($id);

		$this->authorize('delete', $legaldocument);

		$legaldocument->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Legaldocument::class);

		$legaldocuments = \App\Legaldocument::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($legaldocuments as $legaldocument)
			$answer[] = [
				'id'    => $legaldocument->id,
				'value' => $legaldocument->name,
			];

		return response()->json($answer, 200);
	}
}
