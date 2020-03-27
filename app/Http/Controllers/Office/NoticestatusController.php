<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Noticestatus\StoreRequest;
use App\Http\Requests\Office\Noticestatus\UpdateRequest;

class NoticestatusController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar', 'office.noticestatus.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Noticestatus::class);

		$noticestatuses['rows'] = \App\Noticestatus::query()
			->withRelations()
			->withCount('notices')
			->sortBy(
				$noticestatuses['sort']		= $request->sort ?? 'name',
				$noticestatuses['direction']	= $request->direction
			)
			->paginate(config('interface.paginator'))
		;

		return view($this->view, compact('noticestatuses'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$noticestatus = \App\Noticestatus::query()
			->withRelations()
			->withCount('notices')
			->findOrFail($id)
		;

		$this->authorize('read', $noticestatus);

		$parameters['name'] = $noticestatus->name;

		// Вложенные уведомления
		if (auth()->user()->can('index', \App\Notice::class))
			$notices['rows'] = $noticestatus->notices()
				->withRelations()
				->sortBy(
					$notices['sort']      = $request->sort ?? 'created_at',
					$notices['direction'] = $request->direction ?? 'desc'
				)
				->paginate(config('interface.paginator'))
			;

		return view($this->view, compact(
			'parameters',
			'noticestatus'
		))
			->with('notices', $notices ?? [])
		;
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$noticestatus = new \App\Noticestatus;

		$this->authorize('create', $noticestatus);

		return view($this->view, compact('noticestatus'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\NoticestatusStoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$noticestatus = \App\Noticestatus::create($request->all());

		$this->authorize('create', $noticestatus);

		$noticestatus->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $noticestatus->id,
			'name'		=> $noticestatus->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\NoticestatusUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function update(UpdateRequest $request, $id)
	{
		$noticestatus = \App\Noticestatus::query()
			->findOrFail($id);

		$this->authorize('update', $noticestatus);

		$noticestatus->fill($request->all());
		$noticestatus->save();

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
		$noticestatus = \App\Noticestatus::query()
			->findOrFail($id);

		$this->authorize('read', $noticestatus);

		$parameters['name'] = $noticestatus->name;

		return view($this->view, compact(
			'parameters',
			'noticestatus'
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
		$noticestatus = \App\Noticestatus::query()
			->findOrFail($id);

		$this->authorize('delete', $noticestatus);

		$noticestatus->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Noticestatus::class);

		$noticestatuses = \App\Noticestatus::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($noticestatuses as $noticestatus)
			$answer[] = [
				'id'	=> $noticestatus->id,
				'value'	=> $noticestatus->name
			];

		return response()->json($answer, 200);
	}
}
