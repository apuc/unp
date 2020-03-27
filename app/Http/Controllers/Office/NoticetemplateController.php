<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;
use App\Http\Requests\Office\Noticetemplate\StoreRequest;
use App\Http\Requests\Office\Noticetemplate\UpdateRequest;

class NoticetemplateController extends Controller
{
	public function __construct()
	{
		parent::__construct();

		View::share('sidebar',      'office.noticetemplate.index');
	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function index(Request $request)
	{
		$this->authorize('index', \App\Noticetemplate::class);

		$noticetemplates['rows'] = \App\Noticetemplate::query()
			->withRelations()
			->sortBy(
				$noticetemplates['sort'] 		= $request->sort ?? 'name',
				$noticetemplates['direction'] 	= $request->direction
			)
			->paginate(config('interface.paginator'));

		return view($this->view, compact('noticetemplates'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */

	public function show(Request $request, $id)
	{
		$noticetemplate = \App\Noticetemplate::query()
			->withRelations()
			->findOrFail($id)
		;

		$this->authorize('read', $noticetemplate);

		$parameters['name'] = $noticetemplate->name;

		return view($this->view, compact(
			'parameters',
			'noticetemplate'
		));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */

	public function create()
	{
		$noticetemplate = new \App\Noticetemplate;

		$this->authorize('create', $noticetemplate);

		return view($this->view, compact('noticetemplate'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \App\Http\Requests\Noticetemplate\StoreRequest $request
	 * @return \Illuminate\Http\Response
	 */

	public function store(StoreRequest $request)
	{
		$noticetemplate = \App\Noticetemplate::create($request->all());;

		$this->authorize('create', $noticetemplate);

		$noticetemplate->save();

		return response()->json([
			'status'	=> 'success',
			'id'		=> $noticetemplate->id,
			'name'		=> $noticetemplate->name,
		], 200);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \App\Http\Requests\NoticetemplateUpdateRequest $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdateRequest $request, $id)
	{
		$noticetemplate = \App\Noticetemplate::query()
			->findOrFail($id);

		$this->authorize('update', $noticetemplate);

		$noticetemplate->fill($request->all());
		$noticetemplate->save();

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
		$noticetemplate = \App\Noticetemplate::query()
			->findOrFail($id);

		$this->authorize('read', $noticetemplate);

		$parameters['name'] = $noticetemplate->name;

		return view($this->view, compact(
			'parameters',
			'noticetemplate'
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
		$noticetemplate = \App\Noticetemplate::query()
			->findOrFail($id);

		$this->authorize('delete', $noticetemplate);

		$noticetemplate->delete();
	}

	/**
	 * аяксовый поиск записей
	 *
	 * @param  Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function search(Request $request)
	{
		$this->authorize('index', \App\Noticetemplate::class);

		$noticetemplates = \App\Noticetemplate::query()
			->sortBy('name', 'asc')
			->filterBy('name', $request->value)
			->paginate(config('interface.select'))
		;

		$answer = [];
		foreach ($noticetemplates as $noticetemplate)
			$answer[] = [
				'id'    => $noticetemplate->id,
				'value' => $noticetemplate->name,
			];

		return response()->json($answer, 200);
	}
}
