<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Postpicture\StoreRequest;
use App\Http\Requests\Office\Postpicture\UpdateRequest;

class PostpictureController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.postpicture.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Postpicture::class);

		$postpictures['rows'] = \App\Postpicture::query()
			->withRelations()
			->sortBy(
				$postpictures['sort'] 		= $request->sort ?? 'name',
				$postpictures['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('postpictures'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$postpicture = \App\Postpicture::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $postpicture);

		$parameters['name'] = $postpicture->name;

		return view($this->view, compact(
			'parameters',
			'postpicture'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$postpicture = new \App\Postpicture;

		$this->authorize('create', $postpicture);

		return view($this->view, compact('postpicture'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Postpicture\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$postpicture = \App\Postpicture::create($request->all());;

		$this->authorize('create', $postpicture);

		$postpicture->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $postpicture->id,
			'name'		=> $postpicture->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\PostpictureUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$postpicture = \App\Postpicture::query()
			->findOrFail($id);

		$this->authorize('update', $postpicture);

		$postpicture->fill($request->all());
		$postpicture->save();

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
		$postpicture = \App\Postpicture::query()
			->findOrFail($id);

		$this->authorize('read', $postpicture);

		$parameters['name'] = $postpicture->name;

		return view($this->view, compact(
			'parameters',
			'postpicture'
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
		$postpicture = \App\Postpicture::query()
			->findOrFail($id);

		$this->authorize('delete', $postpicture);

		$postpicture->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Postpicture::class);

		$postpictures = \App\Postpicture::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($postpictures as $postpicture)
			$answer[] = [
				'id'    => $postpicture->id,
				'value' => $postpicture->name,
			];

		return response()->json($answer, 200);
	}
}
