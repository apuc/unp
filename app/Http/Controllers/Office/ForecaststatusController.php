<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Forecaststatus\StoreRequest;
use App\Http\Requests\Office\Forecaststatus\UpdateRequest;

class ForecaststatusController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.forecaststatus.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Forecaststatus::class);

		$forecaststatuses['rows'] = \App\Forecaststatus::query()
			->withRelations()
			->withCount('forecasts')
			->sortBy(
				$forecaststatuses['sort']		= $request->sort ?? 'name',
				$forecaststatuses['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'))
		;

		return view($this->view, compact('forecaststatuses'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$forecaststatus = \App\Forecaststatus::query()
			->withRelations()
			->withCount('forecasts')
			->findOrFail($id)
		;

		$this->authorize('read', $forecaststatus);

		$parameters['name'] = $forecaststatus->name;

		// Вложенные прогнозы
		if (auth()->user()->can('index', \App\Forecast::class))
			$forecasts['rows'] = $forecaststatus->forecasts()
				->withRelations()
				->withCount('forecastcomments')
				->withCount('forecastpictures')
				->sortBy(
					$forecasts['sort']      = $request->sort ?? 'created_at',
					$forecasts['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'))
			;

		return view($this->view, compact(
			'parameters',
			'forecaststatus'
		))
			->with('forecasts', $forecasts ?? [])
		;
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$forecaststatus = new \App\Forecaststatus;

		$this->authorize('create', $forecaststatus);

		return view($this->view, compact('forecaststatus'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\ForecaststatusStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$forecaststatus = \App\Forecaststatus::create($request->all());

		$this->authorize('create', $forecaststatus);

		$forecaststatus->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $forecaststatus->id,
			'name'		=> $forecaststatus->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\ForecaststatusUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(UpdateRequest $request, $id)
	{
		$forecaststatus = \App\Forecaststatus::query()
			->findOrFail($id);

		$this->authorize('update', $forecaststatus);

		$forecaststatus->fill($request->all());
		$forecaststatus->save();

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
		$forecaststatus = \App\Forecaststatus::query()
			->findOrFail($id);

		$this->authorize('read', $forecaststatus);

		$parameters['name'] = $forecaststatus->name;

		return view($this->view, compact(
			'parameters',
			'forecaststatus'
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
		$forecaststatus = \App\Forecaststatus::query()
			->findOrFail($id);

		$this->authorize('delete', $forecaststatus);

		$forecaststatus->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Forecaststatus::class);

		$forecaststatuses = \App\Forecaststatus::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($forecaststatuses as $forecaststatus)
			$answer[] = [
				'id'	=> $forecaststatus->id,
				'value'	=> $forecaststatus->name
			];

		return response()->json($answer, 200);
	}
}
