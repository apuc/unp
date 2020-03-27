<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Match\StoreRequest;
use App\Http\Requests\Office\Match\UpdateRequest;

class MatchController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.match.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Match::class);

		$matches['rows'] = \App\Match::query()
			->withRelations()
			->withCount('participants')
			->withCount('forecasts')
			->sortBy(
				$matches['sort'] 		= $request->sort ?? 'name',
				$matches['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('matches'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$match = \App\Match::query()
			->withRelations()
			->withCount('forecasts')
			->findOrFail($id)
		;

		$this->authorize('read', $match);

		$parameters['name'] = $match->name;

		// Вложенные участники
		if (auth()->user()->can('index', \App\Participant::class))
			$participants['rows'] = $match->participants()
				->withRelations()
				->sortBy(
					$participants['sort']		= $request->sort ?? 'name',
					$participants['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные прогнозы
		if (auth()->user()->can('index', \App\Forecast::class))
			$forecasts['rows'] = $match->forecasts()
				->withRelations()
				->withCount('forecastcomments')
				->withCount('forecastpictures')
				->sortBy(
					$forecasts['sort'] 		= $request->sort ?? 'name',
					$forecasts['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'match'
		))
			->with('participants',	$participants ?? [])
			->with('forecasts',		$forecasts ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$match = new \App\Match;

		$this->authorize('create', $match);

		return view($this->view, compact('match'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Match\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$match = \App\Match::create($request->all());;

		$this->authorize('create', $match);

		$match->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $match->id,
			'name'		=>  trans('option.office.match', [
				'name'			=> $match->name,
				'started_at'	=> $match->started_at->format('d.m.Y H:i'),
			]),
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\MatchUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$match = \App\Match::query()
			->findOrFail($id);

		$this->authorize('update', $match);

		$match->fill($request->all());
		$match->save();

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
		$match = \App\Match::query()
			->findOrFail($id);

		$this->authorize('read', $match);

		$parameters['name'] = $match->name;

		return view($this->view, compact(
			'parameters',
			'match'
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
		$match = \App\Match::query()
			->findOrFail($id);

		$this->authorize('delete', $match);

		$match->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Match::class);

		$matches = \App\Match::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($matches as $match)
			$answer[] = [
				'id'    => $match->id,
				'value' =>  trans('option.office.match', [
					'name'			=> $match->name,
					'started_at'	=> $match->started_at->format('d.m.Y H:i'),
				]),
			];

		return response()->json($answer, 200);
	}
}
