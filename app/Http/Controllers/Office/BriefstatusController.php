<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Briefstatus\StoreRequest;
use App\Http\Requests\Office\Briefstatus\UpdateRequest;

class BriefstatusController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.briefstatus.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Briefstatus::class);

		$briefstatuses['rows'] = \App\Briefstatus::query()
			->withRelations()
			->withCount('briefs')
			->sortBy(
				$briefstatuses['sort']		= $request->sort ?? 'name',
				$briefstatuses['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'))
		;

		return view($this->view, compact('briefstatuses'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$briefstatus = \App\Briefstatus::query()
			->withRelations()
			->withCount('briefs')
			->findOrFail($id)
		;

		$this->authorize('read', $briefstatus);

		$parameters['name'] = $briefstatus->name;

		// Вложенные публикации
		if (auth()->user()->can('index', \App\Brief::class))
			$briefs['rows'] = $briefstatus->briefs()
				->withRelations()
				->withCount('briefcomments')
				->withCount('briefpictures')
				->sortBy(
					$briefs['sort']      = $request->sort ?? 'created_at',
					$briefs['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'))
			;

		return view($this->view, compact(
			'parameters',
			'briefstatus'
		))
			->with('briefs', $briefs ?? [])
		;
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$briefstatus = new \App\Briefstatus;

		$this->authorize('create', $briefstatus);

		return view($this->view, compact('briefstatus'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\BriefstatusStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$briefstatus = \App\Briefstatus::create($request->all());

		$this->authorize('create', $briefstatus);

		$briefstatus->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $briefstatus->id,
			'name'		=> $briefstatus->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\BriefstatusUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(UpdateRequest $request, $id)
	{
		$briefstatus = \App\Briefstatus::query()
			->findOrFail($id);

		$this->authorize('update', $briefstatus);

		$briefstatus->fill($request->all());
		$briefstatus->save();

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
		$briefstatus = \App\Briefstatus::query()
			->findOrFail($id);

		$this->authorize('read', $briefstatus);

		$parameters['name'] = $briefstatus->name;

		return view($this->view, compact(
			'parameters',
			'briefstatus'
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
		$briefstatus = \App\Briefstatus::query()
			->findOrFail($id);

		$this->authorize('delete', $briefstatus);

		$briefstatus->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Briefstatus::class);

		$briefstatuses = \App\Briefstatus::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($briefstatuses as $briefstatus)
			$answer[] = [
				'id'	=> $briefstatus->id,
				'value'	=> $briefstatus->name
			];

		return response()->json($answer, 200);
	}
}
