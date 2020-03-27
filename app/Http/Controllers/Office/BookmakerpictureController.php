<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Bookmakerpicture\StoreRequest;
use App\Http\Requests\Office\Bookmakerpicture\UpdateRequest;

class BookmakerpictureController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.bookmakerpicture.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Bookmakerpicture::class);

		$bookmakerpictures['rows'] = \App\Bookmakerpicture::query()
			->withRelations()
			->sortBy(
				$bookmakerpictures['sort'] 		= $request->sort ?? 'name',
				$bookmakerpictures['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('bookmakerpictures'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$bookmakerpicture = \App\Bookmakerpicture::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $bookmakerpicture);

		$parameters['name'] = $bookmakerpicture->name;

		return view($this->view, compact(
			'parameters',
			'bookmakerpicture'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$bookmakerpicture = new \App\Bookmakerpicture;

		$this->authorize('create', $bookmakerpicture);

		return view($this->view, compact('bookmakerpicture'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Bookmakerpicture\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$bookmakerpicture = \App\Bookmakerpicture::create($request->all());;

		$this->authorize('create', $bookmakerpicture);

		$bookmakerpicture->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $bookmakerpicture->id,
			'name'		=> $bookmakerpicture->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BookmakerpictureUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$bookmakerpicture = \App\Bookmakerpicture::query()
			->findOrFail($id);

		$this->authorize('update', $bookmakerpicture);

		$bookmakerpicture->fill($request->all());
		$bookmakerpicture->save();

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
		$bookmakerpicture = \App\Bookmakerpicture::query()
			->findOrFail($id);

		$this->authorize('read', $bookmakerpicture);

		$parameters['name'] = $bookmakerpicture->name;

		return view($this->view, compact(
			'parameters',
			'bookmakerpicture'
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
		$bookmakerpicture = \App\Bookmakerpicture::query()
			->findOrFail($id);

		$this->authorize('delete', $bookmakerpicture);

		$bookmakerpicture->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Bookmakerpicture::class);

		$bookmakerpictures = \App\Bookmakerpicture::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($bookmakerpictures as $bookmakerpicture)
			$answer[] = [
				'id'    => $bookmakerpicture->id,
				'value' => $bookmakerpicture->name,
			];

		return response()->json($answer, 200);
	}
}
