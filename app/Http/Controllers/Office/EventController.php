<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Event\StoreRequest;
use App\Http\Requests\Office\Event\UpdateRequest;

class EventController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.event.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Event::class);

		$events['rows'] = \App\Event::query()
			->withRelations()
			->withCount('notices')
			->sortBy(
				$events['sort'] 		= $request->sort ?? 'name',
				$events['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('events'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$event = \App\Event::query()
			->withRelations()
			->withCount('notices')
			->findOrFail($id)
		;

		$this->authorize('read', $event);

		$parameters['name'] = $event->name;

		// Вложенные уведомления
		if (auth()->user()->can('index', \App\Notice::class))
			$notices['rows'] = $event->notices()
				->withRelations()
				->sortBy(
					$notices['sort'] 		= $request->sort ?? 'posted_at',
					$notices['direction']	= $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'));

		return view($this->view, compact(
			'parameters',
			'event'
		))
			->with('notices',	$notices ?? [])
		;
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$event = new \App\Event;

		$this->authorize('create', $event);

		return view($this->view, compact('event'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Event\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$event = \App\Event::create($request->all());;

		$this->authorize('create', $event);

		$event->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $event->id,
			'name'		=> $event->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\EventUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$event = \App\Event::query()
			->findOrFail($id);

		$this->authorize('update', $event);

		$event->fill($request->all());
		$event->save();

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
		$event = \App\Event::query()
			->findOrFail($id);

		$this->authorize('read', $event);

		$parameters['name'] = $event->name;

		return view($this->view, compact(
			'parameters',
			'event'
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
		$event = \App\Event::query()
			->findOrFail($id);

		$this->authorize('delete', $event);

		$event->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Event::class);

		$events = \App\Event::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($events as $event)
			$answer[] = [
				'id'    => $event->id,
				'value' => $event->name,
			];

		return response()->json($answer, 200);
	}
}
