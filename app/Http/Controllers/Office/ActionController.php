<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Action\StoreRequest;
use App\Http\Requests\Office\Action\UpdateRequest;

class ActionController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.action.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Action::class);

		$actions['rows'] = \App\Action::query()
			->withRelations()
			->withCount('events')
			->withCount('noticebans')
			->withCount('noticetemplates')
			->sortBy(
				$actions['sort'] 		= $request->sort ?? 'name',
				$actions['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('actions'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$action = \App\Action::query()
			->withRelations()
			->withCount('events')
			->withCount('noticebans')
			->withCount('noticetemplates')
			->findOrFail($id)
		;

		$this->authorize('read', $action);

		$parameters['name'] = $action->name;

		// Вложенные события
		if (auth()->user()->can('index', \App\Event::class))
			$events['rows'] = $action->events()
				->withRelations()
				->withCount('notices')
				->sortBy(
					$events['sort']			= $request->sort ?? 'name',
					$events['direction']	= $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные запреты уведомлений
		if (auth()->user()->can('index', \App\Noticeban::class))
			$noticebans['rows'] = $action->noticebans()
				->withRelations()
				->sortBy(
					$noticebans['sort'] 	 = $request->sort ?? 'name',
					$noticebans['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		// Вложенные шаблоны уведомления
		if (auth()->user()->can('index', \App\Noticetemplate::class))
			$noticetemplates['rows'] = $action->noticetemplates()
				->withRelations()
				->sortBy(
					$noticetemplates['sort'] 	  = $request->sort ?? 'name',
					$noticetemplates['direction'] = $request->direction
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'action'
		))
			->with('events',			$events ?? [])
			->with('noticebans',		$noticebans ?? [])
			->with('noticetemplates',	$noticetemplates ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$action = new \App\Action;

		$this->authorize('create', $action);

		return view($this->view, compact('action'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Action\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$action = \App\Action::create($request->all());

		$this->authorize('create', $action);

		$action->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $action->id,
			'name'		=> $action->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\ActionUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$action = \App\Action::query()
			->findOrFail($id);

		$this->authorize('update', $action);

		$action->fill($request->all());
		$action->save();

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
		$action = \App\Action::query()
			->findOrFail($id);

		$this->authorize('read', $action);

		$parameters['name'] = $action->name;

		return view($this->view, compact(
			'parameters',
			'action'
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
		$action = \App\Action::query()
			->findOrFail($id);

		$this->authorize('delete', $action);

		$action->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Action::class);

		$actions = \App\Action::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($actions as $action)
			$answer[] = [
				'id'    => $action->id,
				'value' => $action->name,
			];

		return response()->json($answer, 200);
	}
}
