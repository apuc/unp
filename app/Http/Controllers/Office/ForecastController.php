<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Forecast\StoreRequest;
use App\Http\Requests\Office\Forecast\UpdateRequest;

class ForecastController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('office.filter.forecast', ['only' => ['index']]);

		View::share('sidebar', 'office.forecast.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Forecast::class);

		$forecasts['rows'] = \App\Forecast::query()
			->withRelations()
			->withCount('forecastcomments')
			->withCount('forecastpictures')
			->filter()
			->sortBy(
				$forecasts['sort'] 		= $request->sort ?? 'posted_at',
				$forecasts['direction']	= $request->direction ?? 'desc'
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('forecasts'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$forecast = \App\Forecast::query()
			->withRelations()
			->withCount('forecastcomments')
			->withCount('forecastpictures')
			->findOrFail($id)
		;

		$this->authorize('read', $forecast);

		$parameters['name'] = $forecast->name;

		// Вложенные комментарии
		if (auth()->user()->can('index', \App\Forecastcomment::class))
			$forecastcomments['rows'] = $forecast->forecastcomments()
				->withRelations()
				->sortBy(
					$forecastcomments['sort']		= $request->sort ?? 'name',
					$forecastcomments['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные изображения
		if (auth()->user()->can('index', \App\Forecastpicture::class))
			$forecastpictures['rows'] = $forecast->forecastpictures()
				->withRelations()
				->sortBy(
					$forecastpictures['sort'] 		= $request->sort ?? 'name',
					$forecastpictures['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'forecast'
		))
			->with('forecastcomments',	$forecastcomments ?? [])
			->with('forecastpictures',	$forecastpictures ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$forecast = new \App\Forecast;

		$this->authorize('create', $forecast);

		return view($this->view, compact('forecast'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Forecast\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$forecast = \App\Forecast::create($request->all());;

		$this->authorize('create', $forecast);

		$forecast->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $forecast->id,
			'name'		=> $forecast->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\ForecastUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$forecast = \App\Forecast::query()
			->findOrFail($id)
		;

		$old = clone $forecast;

		$this->authorize('update', $forecast);

		$forecast->fill($request->all());
		$forecast->save();

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
		$forecast = \App\Forecast::query()
			->findOrFail($id);

		$this->authorize('read', $forecast);

		$parameters['name'] = $forecast->name;

		return view($this->view, compact(
			'parameters',
			'forecast'
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
		$forecast = \App\Forecast::query()
			->findOrFail($id);

		$this->authorize('delete', $forecast);

		$forecast->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Forecast::class);

		$forecasts = \App\Forecast::query()
			->sortBy('posted_at', 'desc')
			->filterBy('posted_at', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($forecasts as $forecast)
			$answer[] = [
				'id'    => $forecast->id,
				'value' => trans('option.office.forecast', [
					'id'		=> code($forecast->id),
					'posted_at'	=> $forecast->posted_at,
				])
			];

		return response()->json($answer, 200);
	}
}
