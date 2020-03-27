<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Notice\StoreRequest;
use App\Http\Requests\Office\Notice\UpdateRequest;

class NoticeController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.notice.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Notice::class);

		$notices['rows'] = \App\Notice::query()
			->withRelations()
			->sortBy(
				$notices['sort'] 		= $request->sort ?? 'posted_at',
				$notices['direction'] 	= $request->direction ?? 'desc'
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('notices'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$notice = \App\Notice::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $notice);

		$parameters['name'] = $notice->name;

		return view($this->view, compact(
			'parameters',
			'notice'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$notice = new \App\Notice;

		$this->authorize('create', $notice);

		return view($this->view, compact('notice'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Notice\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$notice = \App\Notice::create($request->all());;

		$this->authorize('create', $notice);

		$notice->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $notice->id,
			'name'		=> $notice->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\NoticeUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$notice = \App\Notice::query()
			->findOrFail($id);

		$this->authorize('update', $notice);

		$notice->fill($request->all());
		$notice->save();

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
		$notice = \App\Notice::query()
			->findOrFail($id);

		$this->authorize('read', $notice);

		$parameters['name'] = $notice->name;

		return view($this->view, compact(
			'parameters',
			'notice'
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
		$notice = \App\Notice::query()
			->findOrFail($id);

		$this->authorize('delete', $notice);

		$notice->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Notice::class);

		$notices = \App\Notice::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($notices as $notice)
			$answer[] = [
				'id'    => $notice->id,
				'value' => $notice->name,
			];

		return response()->json($answer, 200);
	}
}
