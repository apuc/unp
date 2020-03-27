<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Role\StoreRequest;
use App\Http\Requests\Office\Role\UpdateRequest;

class RoleController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.role.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Role::class);

		$roles['rows'] = \App\Role::query()
			->withRelations()
			->withCount('users')
			->sortBy(
				$roles['sort']		= $request->sort ?? 'name',
				$roles['direction'] = $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('roles'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$role = \App\Role::query()
			->withRelations()
			->withCount('users')
			->findOrFail($id)
		;

		$this->authorize('read', $role);

		$parameters['name'] = $role->name;

		// Вложенные пользователи
		if (auth()->user()->can('index', \App\User::class))
			$users['rows'] = $role->users()
				->withRelations()
				->withCount('forecasts')
				->withCount('posts')
				->withCount('postcomments')
				->withCount('briefs')
				->withCount('briefcomments')
				->withCount('forecastcomments')
				->withCount('issues')
				->withCount('usersocials')
				->withCount('notices')
				->withCount('events')
				->sortBy(
					$users['sort'] 		= $request->sort ?? 'login',
					$users['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'role'
		))
			->with('users',	$users ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$role = new \App\Role;

		$this->authorize('create', $role);

		return view($this->view, compact('role'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\RoleStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$role = \App\Role::create($request->all());

		$this->authorize('create', $role);

		$role->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $role->id,
			'name'		=> $role->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\RoleUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$role = \App\Role::query()
			->findOrFail($id);

		$this->authorize('update', $role);

		$role->fill($request->all());
		$role->save();

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
		$role = \App\Role::query()
			->findOrFail($id);

		$this->authorize('read', $role);

		$parameters['name'] = $role->name;

		return view($this->view, compact(
			'parameters',
			'role'
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
		$role = \App\Role::query()
			->findOrFail($id);

		$this->authorize('delete', $role);

		$role->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Role::class);

		$roles = \App\Role::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($roles as $role)
			$answer[] = [
				'id'    => $role->id,
				'value' => $role->name,
			];

		return response()->json($answer, 200);
	}
}
