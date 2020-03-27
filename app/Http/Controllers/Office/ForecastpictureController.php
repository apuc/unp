<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Forecastpicture\StoreRequest;
use App\Http\Requests\Office\Forecastpicture\UpdateRequest;

class ForecastpictureController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.forecastpicture.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Forecastpicture::class);

		$forecastpictures['rows'] = \App\Forecastpicture::query()
			->withRelations()
			->sortBy(
				$forecastpictures['sort'] 		= $request->sort ?? 'name',
				$forecastpictures['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('forecastpictures'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$forecastpicture = \App\Forecastpicture::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $forecastpicture);

		$parameters['name'] = $forecastpicture->name;

		return view($this->view, compact(
			'parameters',
			'forecastpicture'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$forecastpicture = new \App\Forecastpicture;

		$this->authorize('create', $forecastpicture);

		return view($this->view, compact('forecastpicture'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Forecastpicture\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$forecastpicture = \App\Forecastpicture::create($request->all());;

		$this->authorize('create', $forecastpicture);

		$forecastpicture->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $forecastpicture->id,
			'name'		=> $forecastpicture->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\ForecastpictureUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$forecastpicture = \App\Forecastpicture::query()
			->findOrFail($id);

		$this->authorize('update', $forecastpicture);

		$forecastpicture->fill($request->all());
		$forecastpicture->save();

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
		$forecastpicture = \App\Forecastpicture::query()
			->findOrFail($id);

		$this->authorize('read', $forecastpicture);

		$parameters['name'] = $forecastpicture->name;

		return view($this->view, compact(
			'parameters',
			'forecastpicture'
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
		$forecastpicture = \App\Forecastpicture::query()
			->findOrFail($id);

		$this->authorize('delete', $forecastpicture);

		$forecastpicture->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Forecastpicture::class);

		$forecastpictures = \App\Forecastpicture::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($forecastpictures as $forecastpicture)
			$answer[] = [
				'id'    => $forecastpicture->id,
				'value' => $forecastpicture->name,
			];

		return response()->json($answer, 200);
	}
}
