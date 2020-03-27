<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bookmaker\StoreRequest;
use App\Http\Requests\Office\Bookmaker\UpdateRequest;

class BookmakerController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		$this->middleware('office.filter.bookmaker', ['only' => ['index']]);

		View::share('sidebar',      'office.bookmaker.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bookmaker::class);

		$bookmakers['rows'] = \App\Bookmaker::query()
			->withRelations()
			->withCount('forecasts')
			->withCount('offers')
			->withCount('deals')
			->withCount('bookmakertexts')
			->filter()
			->sortBy(
				$bookmakers['sort'] 		= $request->sort ?? 'name',
				$bookmakers['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bookmakers'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bookmaker = \App\Bookmaker::query()
			->withRelations()
			->withCount('forecasts')
			->withCount('offers')
			->withCount('deals')
			->withCount('bookmakertexts')
			->findOrFail($id)
		;

		$this->authorize('read', $bookmaker);

		$parameters['name'] = $bookmaker->name;

		// Вложенные прогнозы
		if (auth()->user()->can('index', \App\Forecast::class))
			$forecasts['rows'] = $bookmaker->forecasts()
				->withRelations()
				->withCount('forecastcomments')
				->withCount('forecastpictures')
				->sortBy(
					$forecasts['sort'] 		= $request->sort ?? 'name',
					$forecasts['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные коэффициенты
		if (auth()->user()->can('index', \App\Offer::class))
			$offers['rows'] = $bookmaker->offers()
				->withRelations()
				->sortBy(
					$offers['sort'] 		= $request->sort ?? 'outcome',
					$offers['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные акции
		if (auth()->user()->can('index', \App\Deal::class))
			$deals['rows'] = $bookmaker->deals()
				->withRelations()
				->sortBy(
					$deals['sort'] 		= $request->sort ?? 'name',
					$deals['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные тексты
		if (auth()->user()->can('index', \App\Bookmakertext::class))
			$bookmakertexts['rows'] = $bookmaker->bookmakertexts()
				->withRelations()
				->withCount('bookmakerpictures')
				->sortBy(
					$bookmakertexts['sort'] 		= $request->sort ?? 'name',
					$bookmakertexts['direction'] 	= $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'bookmaker'
		))
			->with('forecasts',			$forecasts ?? [])
			->with('offers',			$offers ?? [])
			->with('deals',				$deals ?? [])
			->with('bookmakertexts',	$bookmakertexts ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bookmaker = new \App\Bookmaker;

		$this->authorize('create', $bookmaker);

		return view($this->view, compact('bookmaker'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bookmaker\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$bookmaker = \App\Bookmaker::create($request->all());

		$this->authorize('create', $bookmaker);

		$bookmaker->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $bookmaker->id,
			'name'		=> $bookmaker->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BookmakerUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bookmaker = \App\Bookmaker::query()
			->findOrFail($id);

		$this->authorize('update', $bookmaker);

		$bookmaker->fill($request->all());
		$bookmaker->save();

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
		$bookmaker = \App\Bookmaker::query()
			->findOrFail($id);

		$this->authorize('read', $bookmaker);

		$parameters['name'] = $bookmaker->name;

		return view($this->view, compact(
			'parameters',
			'bookmaker'
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
		$bookmaker = \App\Bookmaker::query()
			->findOrFail($id);

		$this->authorize('delete', $bookmaker);

		$bookmaker->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bookmaker::class);

		$bookmakers = \App\Bookmaker::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bookmakers as $bookmaker)
			$answer[] = [
				'id'    => $bookmaker->id,
				'value' => $bookmaker->name,
			];

		return response()->json($answer, 200);
	}
}
