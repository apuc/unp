<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Posttag\StoreRequest;
use App\Http\Requests\Office\Posttag\UpdateRequest;

class PosttagController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.posttag.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Posttag::class);

		$posttags['rows'] = \App\Posttag::query()
			->withRelations()
//			->withCount('users')
			->sortBy(
				$posttags['sort'] 		= $request->sort ?? 'name',
				$posttags['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('posttags'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$posttag = \App\Posttag::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $posttag);

		$parameters['name'] = $posttag->name;

		return view($this->view, compact(
			'parameters',
			'posttag'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$posttag = new \App\Posttag;

		$this->authorize('create', $posttag);

		return view($this->view, compact('posttag'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Posttag\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$posttag = \App\Posttag::create($request->all());;

		$this->authorize('create', $posttag);

		$posttag->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $posttag->id,
			'name'		=> $posttag->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\PosttagUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$posttag = \App\Posttag::query()
			->findOrFail($id);

		$this->authorize('update', $posttag);

		$posttag->fill($request->all());
		$posttag->save();

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
		$posttag = \App\Posttag::query()
			->findOrFail($id);

		$this->authorize('read', $posttag);

		$parameters['name'] = $posttag->name;

		return view($this->view, compact(
			'parameters',
			'posttag'
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
		$posttag = \App\Posttag::query()
			->findOrFail($id);

		$this->authorize('delete', $posttag);

		$posttag->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Posttag::class);

		$posttags = \App\Posttag::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($posttags as $posttag)
			$answer[] = [
				'id'    => $posttag->id,
				'value' => $posttag->name,
			];

		return response()->json($answer, 200);
	}
}
