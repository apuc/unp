<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Brieftag\StoreRequest;
use App\Http\Requests\Office\Brieftag\UpdateRequest;

class BrieftagController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.brieftag.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Brieftag::class);

		$brieftags['rows'] = \App\Brieftag::query()
			->withRelations()
//			->withCount('users')
			->sortBy(
				$brieftags['sort'] 		= $request->sort ?? 'name',
				$brieftags['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('brieftags'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$brieftag = \App\Brieftag::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $brieftag);

		$parameters['name'] = $brieftag->name;

		return view($this->view, compact(
			'parameters',
			'brieftag'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$brieftag = new \App\Brieftag;

		$this->authorize('create', $brieftag);

		return view($this->view, compact('brieftag'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Brieftag\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$brieftag = \App\Brieftag::create($request->all());;

		$this->authorize('create', $brieftag);

		$brieftag->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $brieftag->id,
			'name'		=> $brieftag->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BrieftagUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$brieftag = \App\Brieftag::query()
			->findOrFail($id);

		$this->authorize('update', $brieftag);

		$brieftag->fill($request->all());
		$brieftag->save();

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
		$brieftag = \App\Brieftag::query()
			->findOrFail($id);

		$this->authorize('read', $brieftag);

		$parameters['name'] = $brieftag->name;

		return view($this->view, compact(
			'parameters',
			'brieftag'
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
		$brieftag = \App\Brieftag::query()
			->findOrFail($id);

		$this->authorize('delete', $brieftag);

		$brieftag->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Brieftag::class);

		$brieftags = \App\Brieftag::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($brieftags as $brieftag)
			$answer[] = [
				'id'    => $brieftag->id,
				'value' => $brieftag->name,
			];

		return response()->json($answer, 200);
	}
}
