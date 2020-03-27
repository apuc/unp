<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Actiongroup\StoreRequest;
use App\Http\Requests\Office\Actiongroup\UpdateRequest;

class ActiongroupController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.actiongroup.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Actiongroup::class);

		$actiongroups['rows'] = \App\Actiongroup::query()
			->withRelations()
			->withCount('actions')
			->sortBy(
				$actiongroups['sort'] 		= $request->sort ?? 'name',
				$actiongroups['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('actiongroups'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$actiongroup = \App\Actiongroup::query()
			->withRelations()
			->withCount('actions')
			->findOrFail($id)
		;

		$this->authorize('read', $actiongroup);

		$parameters['name'] = $actiongroup->name;

		// Вложенные действия
		if (auth()->user()->can('index', \App\Action::class))
			$actions['rows'] = $actiongroup->actions()
				->withRelations()
				->withCount('events')
				->withCount('noticebans')
				->withCount('noticetemplates')
				->sortBy(
					$actions['sort']		= $request->sort ?? 'name',
					$actions['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'actiongroup'
		))
			->with('actions',	$actions ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$actiongroup = new \App\Actiongroup;

		$this->authorize('create', $actiongroup);

		return view($this->view, compact('actiongroup'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Actiongroup\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$actiongroup = \App\Actiongroup::create($request->all());

		$this->authorize('create', $actiongroup);

		$actiongroup->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $actiongroup->id,
			'name'		=> $actiongroup->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\ActiongroupUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$actiongroup = \App\Actiongroup::query()
			->findOrFail($id);

		$this->authorize('update', $actiongroup);

		$actiongroup->fill($request->all());
		$actiongroup->save();

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
		$actiongroup = \App\Actiongroup::query()
			->findOrFail($id);

		$this->authorize('read', $actiongroup);

		$parameters['name'] = $actiongroup->name;

		return view($this->view, compact(
			'parameters',
			'actiongroup'
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
		$actiongroup = \App\Actiongroup::query()
			->findOrFail($id);

		$this->authorize('delete', $actiongroup);

		$actiongroup->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Actiongroup::class);

		$actiongroups = \App\Actiongroup::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($actiongroups as $actiongroup)
			$answer[] = [
				'id'    => $actiongroup->id,
				'value' => $actiongroup->name,
			];

		return response()->json($answer, 200);
	}
}
