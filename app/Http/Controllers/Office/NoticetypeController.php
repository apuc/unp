<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Noticetype\StoreRequest;
use App\Http\Requests\Office\Noticetype\UpdateRequest;

class NoticetypeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.noticetype.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Noticetype::class);

		$noticetypes['rows'] = \App\Noticetype::query()
			->withRelations()
			->withCount('notices')
			->sortBy(
				$noticetypes['sort'] 		= $request->sort ?? 'name',
				$noticetypes['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('noticetypes'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$noticetype = \App\Noticetype::query()
			->withRelations()
			->withCount('notices')
			->findOrFail($id)
		;

		$this->authorize('read', $noticetype);

		$parameters['name'] = $noticetype->name;

		// Вложенные уведомления
		if (auth()->user()->can('index', \App\Notice::class))
			$notices['rows'] = $noticetype->notices()
				->withRelations()
				->sortBy(
					$notices['sort']		= $request->sort ?? 'name',
					$notices['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'noticetype'
		))
			->with('notices',	$notices ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$noticetype = new \App\Noticetype;

		$this->authorize('create', $noticetype);

		return view($this->view, compact('noticetype'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Noticetype\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$noticetype = \App\Noticetype::create($request->all());

		$this->authorize('create', $noticetype);

		$noticetype->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $noticetype->id,
			'name'		=> $noticetype->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\NoticetypeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$noticetype = \App\Noticetype::query()
			->findOrFail($id);

		$this->authorize('update', $noticetype);

		$noticetype->fill($request->all());
		$noticetype->save();

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
		$noticetype = \App\Noticetype::query()
			->findOrFail($id);

		$this->authorize('read', $noticetype);

		$parameters['name'] = $noticetype->name;

		return view($this->view, compact(
			'parameters',
			'noticetype'
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
		$noticetype = \App\Noticetype::query()
			->findOrFail($id);

		$this->authorize('delete', $noticetype);

		$noticetype->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Noticetype::class);

		$noticetypes = \App\Noticetype::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($noticetypes as $noticetype)
			$answer[] = [
				'id'    => $noticetype->id,
				'value' => $noticetype->name,
			];

		return response()->json($answer, 200);
	}
}
