<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Issuetype\StoreRequest;
use App\Http\Requests\Office\Issuetype\UpdateRequest;

class IssuetypeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.issuetype.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Issuetype::class);

		$issuetypes['rows'] = \App\Issuetype::query()
			->withRelations()
			->withCount('issues')
			->sortBy(
				$issuetypes['sort'] 		= $request->sort ?? 'name',
				$issuetypes['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('issuetypes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$issuetype = \App\Issuetype::query()
			->withRelations()
			->withCount('issues')
			->findOrFail($id)
		;

		$this->authorize('read', $issuetype);

		$parameters['name'] = $issuetype->name;

		// Вложенные обращения
		if (auth()->user()->can('index', \App\Issue::class))
			$issues['rows'] = $issuetype->issues()
				->withRelations()
				->withCount('answers')
				->sortBy(
					$issues['sort']			= $request->sort ?? 'name',
					$issues['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'issuetype'
		))
			->with('issues',	$issues ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$issuetype = new \App\Issuetype;

		$this->authorize('create', $issuetype);

		return view($this->view, compact('issuetype'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Issuetype\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$issuetype = \App\Issuetype::create($request->all());

		$this->authorize('create', $issuetype);

		$issuetype->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $issuetype->id,
			'name'		=> $issuetype->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\IssuetypeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$issuetype = \App\Issuetype::query()
			->findOrFail($id);

		$this->authorize('update', $issuetype);

		$issuetype->fill($request->all());
		$issuetype->save();

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
		$issuetype = \App\Issuetype::query()
			->findOrFail($id);

		$this->authorize('read', $issuetype);

		$parameters['name'] = $issuetype->name;

		return view($this->view, compact(
			'parameters',
			'issuetype'
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
		$issuetype = \App\Issuetype::query()
			->findOrFail($id);

		$this->authorize('delete', $issuetype);

		$issuetype->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Issuetype::class);

		$issuetypes = \App\Issuetype::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($issuetypes as $issuetype)
			$answer[] = [
				'id'    => $issuetype->id,
				'value' => $issuetype->name,
			];

		return response()->json($answer, 200);
	}
}
