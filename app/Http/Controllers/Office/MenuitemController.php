<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Menuitem\StoreRequest;
use App\Http\Requests\Office\Menuitem\UpdateRequest;

class MenuitemController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.menuitem.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Menuitem::class);

		$menuitems['rows'] = \App\Menuitem::query()
			->withRelations()
			->sortBy(
				$menuitems['sort'] 		= $request->sort ?? 'name',
				$menuitems['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('menuitems'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$menuitem = \App\Menuitem::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $menuitem);

		$parameters['name'] = $menuitem->name;

		return view($this->view, compact(
			'parameters',
			'menuitem'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$menuitem = new \App\Menuitem;

		$this->authorize('create', $menuitem);

		return view($this->view, compact('menuitem'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Menuitem\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$menuitem = \App\Menuitem::create($request->all());

		$this->authorize('create', $menuitem);

		$menuitem->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $menuitem->id,
			'name'		=> $menuitem->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\MenuitemUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$menuitem = \App\Menuitem::query()
			->findOrFail($id);

		$this->authorize('update', $menuitem);

		$menuitem->fill($request->all());
		$menuitem->save();

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
		$menuitem = \App\Menuitem::query()
			->findOrFail($id);

		$this->authorize('read', $menuitem);

		$parameters['name'] = $menuitem->name;

		return view($this->view, compact(
			'parameters',
			'menuitem'
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
		$menuitem = \App\Menuitem::query()
			->findOrFail($id);

		$this->authorize('delete', $menuitem);

		$menuitem->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Menuitem::class);

		$menuitems = \App\Menuitem::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($menuitems as $menuitem)
			$answer[] = [
				'id'    => $menuitem->id,
				'value' => $menuitem->name,
			];

		return response()->json($answer, 200);
	}
}
