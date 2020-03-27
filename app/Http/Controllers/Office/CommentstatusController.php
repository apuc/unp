<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Commentstatus\StoreRequest;
use App\Http\Requests\Office\Commentstatus\UpdateRequest;

class CommentstatusController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.commentstatus.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Commentstatus::class);

		$commentstatuses['rows'] = \App\Commentstatus::query()
			->withRelations()
			->withCount('postcomments')
			->withCount('briefcomments')
			->withCount('forecastcomments')
			->sortBy(
				$commentstatuses['sort']		= $request->sort ?? 'name',
				$commentstatuses['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'))
		;

		return view($this->view, compact('commentstatuses'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$commentstatus = \App\Commentstatus::query()
			->withRelations()
			->withCount('postcomments')
			->withCount('briefcomments')
			->withCount('forecastcomments')
			->findOrFail($id)
		;

		$this->authorize('read', $commentstatus);

		$parameters['name'] = $commentstatus->name;

		// Вложенные комментарии публикаций
		if (auth()->user()->can('index', \App\Postcomment::class))
			$postcomments['rows'] = $commentstatus->postcomments()
				->withRelations()
				->sortBy(
					$postcomments['sort']      = $request->sort ?? 'posted_at',
					$postcomments['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'));

		// Вложенные комментарии новостей
		if (auth()->user()->can('index', \App\Briefcomment::class))
			$briefcomments['rows'] = $commentstatus->briefcomments()
				->withRelations()
				->sortBy(
					$briefcomments['sort']      = $request->sort ?? 'posted_at',
					$briefcomments['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'));

		// Вложенные комментарии прогнозов
		if (auth()->user()->can('index', \App\Forecastcomment::class))
			$forecastcomments['rows'] = $commentstatus->forecastcomments()
				->withRelations()
				->sortBy(
					$forecastcomments['sort']      = $request->sort ?? 'posted_at',
					$forecastcomments['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'commentstatus'
		))
			->with('postcomments',		$postcomments ?? [])
			->with('briefcomments',		$briefcomments ?? [])
			->with('forecastcomments',	$forecastcomments ?? [])
		;
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$commentstatus = new \App\Commentstatus;

		$this->authorize('create', $commentstatus);

		return view($this->view, compact('commentstatus'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\CommentstatusStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$commentstatus = \App\Commentstatus::create($request->all());

		$this->authorize('create', $commentstatus);

		$commentstatus->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $commentstatus->id,
			'name'		=> $commentstatus->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\CommentstatusUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(UpdateRequest $request, $id)
	{
		$commentstatus = \App\Commentstatus::query()
			->findOrFail($id);

		$this->authorize('update', $commentstatus);

		$commentstatus->fill($request->all());
		$commentstatus->save();

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
		$commentstatus = \App\Commentstatus::query()
			->findOrFail($id);

		$this->authorize('read', $commentstatus);

		$parameters['name'] = $commentstatus->name;

		return view($this->view, compact(
			'parameters',
			'commentstatus'
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
		$commentstatus = \App\Commentstatus::query()
			->findOrFail($id);

		$this->authorize('delete', $commentstatus);

		$commentstatus->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Commentstatus::class);

		$commentstatuses = \App\Commentstatus::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($commentstatuses as $commentstatus)
			$answer[] = [
				'id'	=> $commentstatus->id,
				'value'	=> $commentstatus->name
			];

		return response()->json($answer, 200);
	}
}
