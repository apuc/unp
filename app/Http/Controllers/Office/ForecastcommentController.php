<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Forecastcomment\StoreRequest;
use App\Http\Requests\Office\Forecastcomment\UpdateRequest;

class ForecastcommentController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.forecastcomment.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Forecastcomment::class);

		$forecastcomments['rows'] = \App\Forecastcomment::query()
			->withRelations()
			->sortBy(
				$forecastcomments['sort'] 		= $request->sort ?? 'name',
				$forecastcomments['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('forecastcomments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$forecastcomment = \App\Forecastcomment::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $forecastcomment);

		$parameters['name'] = $forecastcomment->name;

		return view($this->view, compact(
			'parameters',
			'forecastcomment'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$forecastcomment = new \App\Forecastcomment;

		$this->authorize('create', $forecastcomment);

		return view($this->view, compact('forecastcomment'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Forecastcomment\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$forecastcomment = \App\Forecastcomment::create($request->all());;

		$this->authorize('create', $forecastcomment);

		$forecastcomment->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $forecastcomment->id,
			'name'		=> $forecastcomment->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\ForecastcommentUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$forecastcomment = \App\Forecastcomment::query()
			->findOrFail($id)
		;

		$old = clone $forecastcomment;

		$this->authorize('update', $forecastcomment);

		$forecastcomment->fill($request->all());
		$forecastcomment->save();

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
		$forecastcomment = \App\Forecastcomment::query()
			->findOrFail($id);

		$this->authorize('read', $forecastcomment);

		$parameters['name'] = $forecastcomment->name;

		return view($this->view, compact(
			'parameters',
			'forecastcomment'
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
		$forecastcomment = \App\Forecastcomment::query()
			->findOrFail($id);

		$this->authorize('delete', $forecastcomment);

		$forecastcomment->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Forecastcomment::class);

		$forecastcomments = \App\Forecastcomment::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($forecastcomments as $forecastcomment)
			$answer[] = [
				'id'    => $forecastcomment->id,
				'value' => $forecastcomment->name,
			];

		return response()->json($answer, 200);
	}
}
