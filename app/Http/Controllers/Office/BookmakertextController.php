<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bookmakertext\StoreRequest;
use App\Http\Requests\Office\Bookmakertext\UpdateRequest;

class BookmakertextController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.bookmakertext.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bookmakertext::class);

		$bookmakertexts['rows'] = \App\Bookmakertext::query()
			->withRelations()
			->withCount('bookmakerpictures')
			->sortBy(
				$bookmakertexts['sort'] 		= $request->sort ?? 'name',
				$bookmakertexts['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bookmakertexts'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bookmakertext = \App\Bookmakertext::query()
			->withRelations()
			->withCount('bookmakerpictures')
			->findOrFail($id)
		;

		$this->authorize('read', $bookmakertext);

		$parameters['name'] = $bookmakertext->name;

		// Вложенные изображения букмекера
		if (auth()->user()->can('index', \App\Bookmakerpicture::class))
			$bookmakerpictures['rows'] = $bookmakertext->bookmakerpictures()
				->withRelations()
				->sortBy(
					$bookmakerpictures['sort'] 		= $request->sort ?? 'name',
					$bookmakerpictures['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'bookmakertext'
		))
			->with('bookmakerpictures',	$bookmakerpictures ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bookmakertext = new \App\Bookmakertext;

		$this->authorize('create', $bookmakertext);

		return view($this->view, compact('bookmakertext'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bookmakertext\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$bookmakertext = \App\Bookmakertext::create($request->all());;

		$this->authorize('create', $bookmakertext);

		$bookmakertext->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $bookmakertext->id,
			'name'		=> $bookmakertext->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BookmakertextUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bookmakertext = \App\Bookmakertext::query()
			->findOrFail($id);

		$this->authorize('update', $bookmakertext);

		$bookmakertext->fill($request->all());
		$bookmakertext->save();

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
		$bookmakertext = \App\Bookmakertext::query()
			->findOrFail($id);

		$this->authorize('read', $bookmakertext);

		$parameters['name'] = $bookmakertext->name;

		return view($this->view, compact(
			'parameters',
			'bookmakertext'
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
		$bookmakertext = \App\Bookmakertext::query()
			->findOrFail($id);

		$this->authorize('delete', $bookmakertext);

		$bookmakertext->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bookmakertext::class);

		$bookmakertexts = \App\Bookmakertext::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bookmakertexts as $bookmakertext)
			$answer[] = [
				'id'    => $bookmakertext->id,
				'value' => $bookmakertext->name,
			];

		return response()->json($answer, 200);
	}
}
