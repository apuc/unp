<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Issuestatus\StoreRequest;
use App\Http\Requests\Office\Issuestatus\UpdateRequest;

class IssuestatusController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.issuestatus.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Issuestatus::class);

		$issuestatuses['rows'] = \App\Issuestatus::query()
			->withRelations()
//			->withCount('issues')
			->sortBy(
				$issuestatuses['sort']		= $request->sort ?? 'name',
				$issuestatuses['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'))
		;

		return view($this->view, compact('issuestatuses'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$issuestatus = \App\Issuestatus::query()
			->withRelations()
			->withCount('issues')
			->findOrFail($id)
		;

		$this->authorize('read', $issuestatus);

		$parameters['name'] = $issuestatus->name;

		// Вложенные обращения
		if (auth()->user()->can('index', \App\Issue::class))
			$issues['rows'] = $issuestatus->issues()
				->withRelations()
				->withCount('answers')
				->sortBy(
					$issues['sort']      = $request->sort ?? 'created_at',
					$issues['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'))
			;

		return view($this->view, compact(
			'parameters',
			'issuestatus'
		))
			->with('issues', $issues ?? [])
		;
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$issuestatus = new \App\Issuestatus;

		$this->authorize('create', $issuestatus);

		return view($this->view, compact('issuestatus'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\IssuestatusStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$issuestatus = \App\Issuestatus::create($request->all());

		$this->authorize('create', $issuestatus);

		$issuestatus->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $issuestatus->id,
			'name'		=> $issuestatus->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\IssuestatusUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(UpdateRequest $request, $id)
	{
		$issuestatus = \App\Issuestatus::query()
			->findOrFail($id);

		$this->authorize('update', $issuestatus);

		$issuestatus->fill($request->all());
		$issuestatus->save();

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
		$issuestatus = \App\Issuestatus::query()
			->findOrFail($id);

		$this->authorize('read', $issuestatus);

		$parameters['name'] = $issuestatus->name;

		return view($this->view, compact(
			'parameters',
			'issuestatus'
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
		$issuestatus = \App\Issuestatus::query()
			->findOrFail($id);

		$this->authorize('delete', $issuestatus);

		$issuestatus->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Issuestatus::class);

		$issuestatuses = \App\Issuestatus::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($issuestatuses as $issuestatus)
			$answer[] = [
				'id'	=> $issuestatus->id,
				'value'	=> $issuestatus->name
			];

		return response()->json($answer, 200);
	}
}
