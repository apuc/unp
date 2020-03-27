<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Menusection\StoreRequest;
use App\Http\Requests\Office\Menusection\UpdateRequest;

class MenusectionController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.menusection.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Menusection::class);

		$menusections['rows'] = \App\Menusection::query()
			->withRelations()
			->withCount('menuitems')
			->sortBy(
				$menusections['sort'] 		= $request->sort ?? 'position',
				$menusections['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('menusections'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$menusection = \App\Menusection::query()
			->withRelations()
			->withCount('menuitems')
			->findOrFail($id)
		;

		$this->authorize('read', $menusection);

		$parameters['name'] = $menusection->name;

		// Вложенные пункты меню
		if (auth()->user()->can('index', \App\Menuitem::class))
			$menuitems['rows'] = $menusection->menuitems()
				->withRelations()
				->sortBy(
					$menuitems['sort']		= $request->sort ?? 'position',
					$menuitems['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'menusection'
		))
			->with('menuitems',	$menuitems ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$menusection = new \App\Menusection;

		$this->authorize('create', $menusection);

		return view($this->view, compact('menusection'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Menusection\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$menusection = \App\Menusection::create($request->all());

		$this->authorize('create', $menusection);

		$menusection->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $menusection->id,
			'name'		=> $menusection->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\MenusectionUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$menusection = \App\Menusection::query()
			->findOrFail($id);

		$this->authorize('update', $menusection);

		$menusection->fill($request->all());
		$menusection->save();

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
		$menusection = \App\Menusection::query()
			->findOrFail($id);

		$this->authorize('read', $menusection);

		$parameters['name'] = $menusection->name;

		return view($this->view, compact(
			'parameters',
			'menusection'
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
		$menusection = \App\Menusection::query()
			->findOrFail($id);

		$this->authorize('delete', $menusection);

		$menusection->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Menusection::class);

		$menusections = \App\Menusection::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($menusections as $menusection)
			$answer[] = [
				'id'    => $menusection->id,
				'value' => $menusection->name,
			];

		return response()->json($answer, 200);
	}
}
