<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Postcomment\StoreRequest;
use App\Http\Requests\Office\Postcomment\UpdateRequest;

class PostcommentController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.postcomment.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Postcomment::class);

		$postcomments['rows'] = \App\Postcomment::query()
			->withRelations()
			->sortBy(
				$postcomments['sort'] 		= $request->sort ?? 'name',
				$postcomments['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('postcomments'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$postcomment = \App\Postcomment::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $postcomment);

		$parameters['name'] = $postcomment->name;

		return view($this->view, compact(
			'parameters',
			'postcomment'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$postcomment = new \App\Postcomment;

		$this->authorize('create', $postcomment);

		return view($this->view, compact('postcomment'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Postcomment\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$postcomment = \App\Postcomment::create($request->all());;

		$this->authorize('create', $postcomment);

		$postcomment->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $postcomment->id,
			'name'		=> $postcomment->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\PostcommentUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$postcomment = \App\Postcomment::query()
			->findOrFail($id)
		;

		$old = clone $postcomment;

		$this->authorize('update', $postcomment);

		$postcomment->fill($request->all());
		$postcomment->save();

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
		$postcomment = \App\Postcomment::query()
			->findOrFail($id);

		$this->authorize('read', $postcomment);

		$parameters['name'] = $postcomment->name;

		return view($this->view, compact(
			'parameters',
			'postcomment'
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
		$postcomment = \App\Postcomment::query()
			->findOrFail($id);

		$this->authorize('delete', $postcomment);

		$postcomment->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Postcomment::class);

		$postcomments = \App\Postcomment::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($postcomments as $postcomment)
			$answer[] = [
				'id'    => $postcomment->id,
				'value' => $postcomment->name,
			];

		return response()->json($answer, 200);
	}
}
