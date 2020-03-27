<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Country\StoreRequest;
use App\Http\Requests\Office\Country\UpdateRequest;

class CountryController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('office.filter.country', ['only' => ['index']]);

		View::share('sidebar',      'office.country.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Country::class);

		$countries['rows'] = \App\Country::query()
			->withRelations()
			->withCount('teams')
			->withCount('stages')
			->filter()
			->sortBy(
				$countries['sort'] 		= $request->sort ?? 'name',
				$countries['direction'] = $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('countries'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$country = \App\Country::query()
			->withRelations()
			->withCount('teams')
			->withCount('stages')
			->findOrFail($id)
		;

		$this->authorize('read', $country);

		$parameters['name'] = $country->name;

		// Вложенные команды

		if (auth()->user()->can('index', \App\Team::class))
			$teams['rows'] = $country->teams()
				->withRelations()
				->sortBy(
					$teams['sort'] 		= $request->sort ?? 'name',
					$teams['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные этапы
		if (auth()->user()->can('index', \App\Stage::class))
			$stages['rows'] = $country->stages()
				->withRelations()
				->withCount('matches')
				->sortBy(
					$stages['sort']			= $request->sort ?? 'name',
					$stages['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'country'
		))
			->with('stages',	$stages	?? [])
			->with('teams',		$teams	?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$country = new \App\Country;

		$this->authorize('create', $country);

		return view($this->view, compact('country'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Country\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$country = \App\Country::create($request->all());;

		$this->authorize('create', $country);

		$country->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $country->id,
			'name'		=> $country->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\CountryUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$country = \App\Country::query()
			->findOrFail($id);

		$this->authorize('update', $country);

		$country->fill($request->all());
		$country->save();

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
		$country = \App\Country::query()
			->findOrFail($id);

		$this->authorize('read', $country);

		$parameters['name'] = $country->name;

		return view($this->view, compact(
			'parameters',
			'country'
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
		$country = \App\Country::query()
			->findOrFail($id);

		$this->authorize('delete', $country);

		$country->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Country::class);

		$countries = \App\Country::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($countries as $country)
			$answer[] = [
				'id'    => $country->id,
				'value' => $country->name,
			];

		return response()->json($answer, 200);
	}
}
