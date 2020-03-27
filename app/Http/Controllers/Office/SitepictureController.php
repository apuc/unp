<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Sitepicture\StoreRequest;
use App\Http\Requests\Office\Sitepicture\UpdateRequest;

class SitepictureController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.sitepicture.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Sitepicture::class);

		$sitepictures['rows'] = \App\Sitepicture::query()
			->withRelations()
			->sortBy(
				$sitepictures['sort'] 		= $request->sort ?? 'name',
				$sitepictures['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('sitepictures'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$sitepicture = \App\Sitepicture::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $sitepicture);

		$parameters['name'] = $sitepicture->name;

		return view($this->view, compact(
			'parameters',
			'sitepicture'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$sitepicture = new \App\Sitepicture;

		$this->authorize('create', $sitepicture);

		return view($this->view, compact('sitepicture'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Sitepicture\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$sitepicture = \App\Sitepicture::create($request->all());;

		$this->authorize('create', $sitepicture);

		$sitepicture->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $sitepicture->id,
			'name'		=> $sitepicture->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\SitepictureUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$sitepicture = \App\Sitepicture::query()
			->findOrFail($id);

		$this->authorize('update', $sitepicture);

		$sitepicture->fill($request->all());
		$sitepicture->save();

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
		$sitepicture = \App\Sitepicture::query()
			->findOrFail($id);

		$this->authorize('read', $sitepicture);

		$parameters['name'] = $sitepicture->name;

		return view($this->view, compact(
			'parameters',
			'sitepicture'
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
		$sitepicture = \App\Sitepicture::query()
			->findOrFail($id);

		$this->authorize('delete', $sitepicture);

		$sitepicture->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Sitepicture::class);

		$sitepictures = \App\Sitepicture::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($sitepictures as $sitepicture)
			$answer[] = [
				'id'    => $sitepicture->id,
				'value' => $sitepicture->name,
			];

		return response()->json($answer, 200);
	}
}
