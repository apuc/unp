<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Usersocial\StoreRequest;
use App\Http\Requests\Office\Usersocial\UpdateRequest;

class UsersocialController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.usersocial.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Usersocial::class);

		$usersocials['rows'] = \App\Usersocial::query()
			->withRelations()
			->sortBy(
				$usersocials['sort'] 		= $request->sort ?? 'name',
				$usersocials['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('usersocials'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$usersocial = \App\Usersocial::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $usersocial);

		$parameters['name'] = $usersocial->name;

		return view($this->view, compact(
			'parameters',
			'usersocial'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$usersocial = new \App\Usersocial;

		$this->authorize('create', $usersocial);

		return view($this->view, compact('usersocial'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Usersocial\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$usersocial = \App\Usersocial::create($request->all());;

		$this->authorize('create', $usersocial);

		$usersocial->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $usersocial->id,
			'name'		=> $usersocial->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\UsersocialUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$usersocial = \App\Usersocial::query()
			->findOrFail($id);

		$this->authorize('update', $usersocial);

		$usersocial->fill($request->all());
		$usersocial->save();

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
		$usersocial = \App\Usersocial::query()
			->findOrFail($id);

		$this->authorize('read', $usersocial);

		$parameters['name'] = $usersocial->name;

		return view($this->view, compact(
			'parameters',
			'usersocial'
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
		$usersocial = \App\Usersocial::query()
			->findOrFail($id);

		$this->authorize('delete', $usersocial);

		$usersocial->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Usersocial::class);

		$usersocials = \App\Usersocial::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($usersocials as $usersocial)
			$answer[] = [
				'id'    => $usersocial->id,
				'value' => $usersocial->name,
			];

		return response()->json($answer, 200);
	}
}
