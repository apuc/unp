<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Poststatus\StoreRequest;
use App\Http\Requests\Office\Poststatus\UpdateRequest;

class PoststatusController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.poststatus.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Poststatus::class);

		$poststatuses['rows'] = \App\Poststatus::query()
			->withRelations()
			->withCount('posts')
			->sortBy(
				$poststatuses['sort']		= $request->sort ?? 'name',
				$poststatuses['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'))
		;

		return view($this->view, compact('poststatuses'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$poststatus = \App\Poststatus::query()
			->withRelations()
			->withCount('posts')
			->findOrFail($id)
		;

		$this->authorize('read', $poststatus);

		$parameters['name'] = $poststatus->name;

		// Вложенные публикации
		if (auth()->user()->can('index', \App\Post::class))
			$posts['rows'] = $poststatus->posts()
				->withRelations()
				->withCount('postcomments')
				->withCount('postpictures')
				->sortBy(
					$posts['sort']      = $request->sort ?? 'created_at',
					$posts['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'))
			;

		return view($this->view, compact(
			'parameters',
			'poststatus'
		))
			->with('posts', $posts ?? [])
		;
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$poststatus = new \App\Poststatus;

		$this->authorize('create', $poststatus);

		return view($this->view, compact('poststatus'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\PoststatusStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$poststatus = \App\Poststatus::create($request->all());

		$this->authorize('create', $poststatus);

		$poststatus->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $poststatus->id,
			'name'		=> $poststatus->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\PoststatusUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(UpdateRequest $request, $id)
	{
		$poststatus = \App\Poststatus::query()
			->findOrFail($id);

		$this->authorize('update', $poststatus);

		$poststatus->fill($request->all());
		$poststatus->save();

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
		$poststatus = \App\Poststatus::query()
			->findOrFail($id);

		$this->authorize('read', $poststatus);

		$parameters['name'] = $poststatus->name;

		return view($this->view, compact(
			'parameters',
			'poststatus'
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
		$poststatus = \App\Poststatus::query()
			->findOrFail($id);

		$this->authorize('delete', $poststatus);

		$poststatus->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Poststatus::class);

		$poststatuses = \App\Poststatus::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($poststatuses as $poststatus)
			$answer[] = [
				'id'	=> $poststatus->id,
				'value'	=> $poststatus->name
			];

		return response()->json($answer, 200);
	}
}
