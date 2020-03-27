<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Customgroup\StoreRequest;
use App\Http\Requests\Office\Customgroup\UpdateRequest;

class CustomgroupController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.customgroup.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Customgroup::class);

		$customgroups['rows'] = \App\Customgroup::query()
			->withRelations()
			->withCount('customparams')
			->sortBy(
				$customgroups['sort'] 		= $request->sort ?? 'name',
				$customgroups['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('customgroups'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$customgroup = \App\Customgroup::query()
			->withRelations()
			->withCount('customparams')
			->findOrFail($id)
		;

		$this->authorize('read', $customgroup);

		$parameters['name'] = $customgroup->name;

		// Вложенные параметры
		if (auth()->user()->can('index', \App\Customparam::class))
			$customparams['rows'] = $customgroup->customparams()
				->withRelations()
				->sortBy(
					$customparams['sort']		= $request->sort ?? 'name',
					$customparams['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'customgroup'
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
		$customgroup = new \App\Customgroup;

		$this->authorize('create', $customgroup);

		return view($this->view, compact('customgroup'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Customgroup\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$customgroup = \App\Customgroup::create($request->all());

		$this->authorize('create', $customgroup);

		$customgroup->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $customgroup->id,
			'name'		=> $customgroup->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\CustomgroupUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$customgroup = \App\Customgroup::query()
			->findOrFail($id);

		$this->authorize('update', $customgroup);

		$customgroup->fill($request->all());
		$customgroup->save();

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
		$customgroup = \App\Customgroup::query()
			->findOrFail($id);

		$this->authorize('read', $customgroup);

		$parameters['name'] = $customgroup->name;

		return view($this->view, compact(
			'parameters',
			'customgroup'
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
		$customgroup = \App\Customgroup::query()
			->findOrFail($id);

		$this->authorize('delete', $customgroup);

		$customgroup->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Customgroup::class);

		$customgroups = \App\Customgroup::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($customgroups as $customgroup)
			$answer[] = [
				'id'    => $customgroup->id,
				'value' => $customgroup->name,
			];

		return response()->json($answer, 200);
	}
}
