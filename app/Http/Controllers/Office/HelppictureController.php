<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Helppicture\StoreRequest;
use App\Http\Requests\Office\Helppicture\UpdateRequest;

class HelppictureController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.helppicture.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Helppicture::class);

		$helppictures['rows'] = \App\Helppicture::query()
			->withRelations()
			->sortBy(
				$helppictures['sort'] 		= $request->sort ?? 'name',
				$helppictures['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('helppictures'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$helppicture = \App\Helppicture::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $helppicture);

		$parameters['name'] = $helppicture->name;

		return view($this->view, compact(
			'parameters',
			'helppicture'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$helppicture = new \App\Helppicture;

		$this->authorize('create', $helppicture);

		return view($this->view, compact('helppicture'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Helppicture\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$helppicture = \App\Helppicture::create($request->all());;

		$this->authorize('create', $helppicture);

		$helppicture->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $helppicture->id,
			'name'		=> $helppicture->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\HelppictureUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$helppicture = \App\Helppicture::query()
			->findOrFail($id);

		$this->authorize('update', $helppicture);

		$helppicture->fill($request->all());
		$helppicture->save();

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
		$helppicture = \App\Helppicture::query()
			->findOrFail($id);

		$this->authorize('read', $helppicture);

		$parameters['name'] = $helppicture->name;

		return view($this->view, compact(
			'parameters',
			'helppicture'
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
		$helppicture = \App\Helppicture::query()
			->findOrFail($id);

		$this->authorize('delete', $helppicture);

		$helppicture->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Helppicture::class);

		$helppictures = \App\Helppicture::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($helppictures as $helppicture)
			$answer[] = [
				'id'    => $helppicture->id,
				'value' => $helppicture->name,
			];

		return response()->json($answer, 200);
	}
}
