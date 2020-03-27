<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Noticeban\StoreRequest;
use App\Http\Requests\Office\Noticeban\UpdateRequest;

class NoticebanController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.noticeban.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Noticeban::class);

		$noticebans['rows'] = \App\Noticeban::query()
			->withRelations()
			->sortBy(
				$noticebans['sort'] 		= $request->sort ?? 'name',
				$noticebans['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('noticebans'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$noticeban = \App\Noticeban::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $noticeban);

		$parameters['name'] = $noticeban->name;

		return view($this->view, compact(
			'parameters',
			'noticeban'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$noticeban = new \App\Noticeban;

		$this->authorize('create', $noticeban);

		return view($this->view, compact('noticeban'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Noticeban\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$noticeban = \App\Noticeban::create($request->all());;

		$this->authorize('create', $noticeban);

		$noticeban->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $noticeban->id,
			'name'		=> $noticeban->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\NoticebanUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$noticeban = \App\Noticeban::query()
			->findOrFail($id);

		$this->authorize('update', $noticeban);

		$noticeban->fill($request->all());
		$noticeban->save();

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
		$noticeban = \App\Noticeban::query()
			->findOrFail($id);

		$this->authorize('read', $noticeban);

		$parameters['name'] = $noticeban->name;

		return view($this->view, compact(
			'parameters',
			'noticeban'
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
		$noticeban = \App\Noticeban::query()
			->findOrFail($id);

		$this->authorize('delete', $noticeban);

		$noticeban->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Noticeban::class);

		$noticebans = \App\Noticeban::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($noticebans as $noticeban)
			$answer[] = [
				'id'    => $noticeban->id,
				'value' => $noticeban->name,
			];

		return response()->json($answer, 200);
	}
}
